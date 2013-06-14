package controllers

import play.api._
import Play.current
import play.api.mvc._
import play.api.data.Form
import play.api.data.Forms._
import play.api.db.DB
import anorm._
import SqlParser._
import java.util.Date

object Application extends Controller {

  /**
   * The form responsible for collecting the email.
   */
  val emailForm = Form(
    single("email" -> email)
  )

  def index = Action {
    Ok(views.html.index("Your new application is ready."))
  }

  /**
   * adds users to the mailing list after they provide their email.
   * @return
   */
  def joinMailing = Action { implicit request =>
    emailForm.bindFromRequest.fold(
      errorForm => BadRequest(views.html.index("")),
      email => {
        // confirm that there is no one with the specified email.
        val emailCount = DB.withConnection { implicit con =>
          SQL("select count(*) from lifebank_mailing_list where email = {email}")
            .on('email -> email)
            .as(scalar[Long].single)
        }

        if (emailCount == 0) {
          DB.withConnection { implicit con =>
            SQL("insert into lifebank_mailing_list (email, created_on) values ({email}, {created_on})")
              .on('email -> email, 'created_on -> new Date)
              .executeInsert()
          }
          Ok(views.html.success())
        } else {
          // show an error page showing
          BadRequest(views.html.index(""))
        }
      }
    )
  }

  /**
   * shows the success page.
   * @return
   */
  def success = Action {
    Ok(views.html.success())
  }
}
