<?php include 'header.php'; ?>

<?php $locations = $hospital->get_locations(); ?>

<?php //var_dump($locations); ?>
<form action="<?php echo SITEURL; ?>/login">
    <div class="container">
        <section class="register">
            <form method="post" action="index.html">
                <div class="reg_section personal_info">
                    <h3>Hospital Name</h3>
                    <input type="text" name="hospital_name" value="" placeholder="Your Desired Username">
                </div>
                <div class="reg_section personal_info">
                    <h3>Phone Number</h3>
                    <input type="text" name="hospital_phone" value="" placeholder="Your Desired Username">
                </div>
                <div class="reg_section personal_info">
                    <h3>Hospital Email</h3>
                    <input type="text" name="hospital_email" value="" placeholder="Your Desired Username">
                </div>
                <div class="reg_section personal_info">
                    <h3>Address</h3>
                    <input type="text" name="hospital_address" value="" placeholder="">
                </div>
                  <div class="reg_section personal_info">
                    <h3>Location</h3>
                    <input type="text" id="locations" name="hospital_location" value="" placeholder="">
                </div>
                <div class="reg_section password">
                    <h3>Location</h3>
                    <select>
                        <option value="">Egypt</option>
                        <option value="">Palastine</option>
                        <option value="">Syria</option>
                        <option value="">Italy</option>
                    </select>
                </div>
                <div class="reg_section personal_info">
                    <h3>Logo</h3>
                    <input type="file" name="hospital_logo" value="" placeholder="">
                </div>
                <p class="submit"><input type="submit" name="commit" value="Sign Up"></p>
            </form>
        </section>
    </div>

</form>

<script type="text/javascript"> 
    jQuery(document).ready(function() { 
        var locations = <?php echo $locations; ?>; 
         //search the last name
        jQuery('#locations').typeahead({
            source: locations,
            items:10
        })  
    }); 
</script>