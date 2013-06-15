package models

import scala.slick.driver.MySQLDriver.simple._
import java.sql.Time

/**
 * User: Victor Igbokwe (vicsstar@yahoo.com)
 * Date: 6/13/13
 * Time: 6:32 PM
 */
case class User(
  id: Long,
  name: Option[String],
  username: Option[String],
  bloodGroup: Option[String],
  phoneNumber: Option[String],
  email: String,
  password: String,
  avatar: Option[String],
  address: Option[String],
  city: String,
  state: String,
  country: String,
  zipCode: Option[String],
  createdOn: Time,
  modifiedOn: Option[Time]
)

object Donors extends Table[User]("users") {
  def id = column[Long]("user_id", O.PrimaryKey, O.AutoInc)
  def name = column[Option[String]]("name", O.Nullable)
  def username = column[Option[String]]("username", O.Nullable)
  def bloodGroup = column[Option[String]]("blood_group", O.Nullable)
  def phoneNumber = column[Option[String]]("phone_number", O.Nullable)
  def email = column[String]("email")
  def password = column[String]("password")
  def avatar = column[Option[String]]("avatar", O.Nullable)
  def address = column[Option[String]]("address", O.Nullable)
  def city = column[String]("city")
  def state = column[String]("state")
  def country = column[String]("country")
  def zipCode = column[Option[String]]("zip_code", O.Nullable)
  def createdOn = column[Time]("created_on")
  def modifiedOn = column[Option[Time]]("modified_on", O.Nullable)

  def * = null

  def idx_email = index("idx_donors__email", email, unique = true)
}