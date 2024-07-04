<?php
session_start();

include 'header.php';

?>

<div id="contact" class="contact-area section-padding">
    <div class="container">
        <div class="section-title text-center my-3">
            <h1>How can we help you?</h1>
            <p>
                Contact us
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12 justify-content-center d-flex">
                <div class="form-fill">
                    <div class="contact justify-content-center d-flex">
                        <table>
                            <div class="row">
                                <tr id="row1">
                                    <td>
                                        <div id="data1">
                                            <input type="text" name="name" class="form-control" placeholder="Name"
                                                required="required" />
                                        </div>
                                    </td>
                                    <td>
                                        <div id="data2">
                                            <input type="email" name="email" class="form-control" placeholder="Email"
                                                required="required" />
                                        </div>
                                    </td>
                                </tr>
                                <tr id="row2">
                                    <td id="data3" colspan="2">
                                        <div>
                                            <input style="width: 100%;" type="text" name="subject" class="form-control"
                                                placeholder="Subject" required="required" />
                                        </div>
                                    </td>
                                </tr>
                                <tr id="row3">
                                    <td id="data4" colspan="2">
                                        <div>
                                            <textarea rows="6" name="message" id="feedback" class="form-control"
                                                placeholder="   Your Message" required="required"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="row4">
                                            <button type="submit" value="Send message" name="submit" id="submitButton"
                                                class="btn btn-contact-bg" title="Submit Your Message!">
                                                Send Message
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
            <!--- END COL -->
            <div class="col-lg-4 col-12  justify-content-center">
                <div id="contactus-buttons">
                    <div class="single_address">
                        <button onclick="gotoLink(this)" value="https://goo.gl/maps/ipQFyJDhSLGeS6X39" id="map"><i
                                id="MAP" class="fa fa-map-marker"></i></button>
                        <h4>Our Address</h4>
                        <p>Bourj Hammoud</p>
                    </div>
                    <div class="single_address">
                        <button onclick="gotoLink(this)" value="mailto:jeangarodk@gmail.com" id="email"><i id="EMAIL"
                                class="fa fa-envelope"></i></button>
                        <h4>Send your message</h4>
                        <p>jeangarodk@gmail.com</p>
                    </div>
                    <div class="single_address">
                        <button onclick="gotoLink(this)" value="tel:+96171062445" id="call"><i id="CALL"
                                class="fa fa-phone"></i></button>
                        <h4>Call us on</h4>
                        <p>(+961) 71-062 445</p>
                    </div>
                    <div class="single_address">
                        <button disabled id="clock"><i class="fa fa-clock-o" id="fa-clock-o"></i></button>
                        <h4 id="time">Work Time</h4>
                        <p>Mon - Fri: 08.00 - 16.00. <br />Sat: 10.00 - 14.00</p>
                    </div>
                </div>
            </div>
            <!--- END COL -->
        </div>
        <!--- END ROW -->
    </div>
    <!--- END CONTAINER -->
</div>


<script>

    // Hiding the 2 contact us buttons in the header
    document.addEventListener('DOMContentLoaded', function () {
        // Hide login buttons
        document.querySelectorAll('header ul li.contactus1, div.header-div-nav-links2 li.contactus2').forEach(btn => {
            btn.style.display = 'none';
        });
    });

    window.addEventListener('load', checkButtonState);
    window.addEventListener('resize', checkButtonState);

    function checkButtonState() {
        var button = document.getElementById('call');
        button.disabled = window.innerWidth > 500; // Disable only if width > 500
    }

    function gotoLink(button) {
        const link = button.getAttribute('value'); // Get the 'value' attribute of the button

        if (link.startsWith("mailto:")) {
            window.location.href = link; // Open email client directly
        } else if (link.startsWith("tel:")) {
            window.location.href = link; // Open phone dialer directly
        } else {
            // For other links (e.g., maps)
            window.open(link, '_blank');  // Open in a new window or tab
        }
    }
</script>

<?php include 'footer.php'; ?>