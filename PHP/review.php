<!-- <?php
session_start();


if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'owner') {
    header("Location: http://localhost/resto/PHP/restaurant_owner_homepage.php");
    exit();
}

include 'header.php';

?>


<div class="container review-container">
    <div class="card review-card">
        <div class="row">
            <div class="col-5">
                <h5>Your rating:</h5>
            </div>
            <div class="review-rating col-6">
                <input type="radio" id="star-1" name="star-radio" value="star-1">
                <label for="star-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path pathLength="360"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star-2" name="star-radio" value="star-1">
                <label for="star-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path pathLength="360"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star-3" name="star-radio" value="star-1">
                <label for="star-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path pathLength="360"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star-4" name="star-radio" value="star-1">
                <label for="star-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path pathLength="360"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                        </path>
                    </svg>
                </label>
                <input type="radio" id="star-5" name="star-radio" value="star-1">
                <label for="star-5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path pathLength="360"
                            d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z">
                        </path>
                    </svg>
                </label>
            </div>
        </div>
        <!-- <div>
            <h5>Tell us about your experience:</h5>
        </div>
        <div>
            <textarea rows="6" name="message" id="experience-feedback" class="form-control"
                placeholder="   Your Message" required="required"></textarea>
        </div>
        <button type="submit" value="submit-review" name="submit" id="" class="btn submit-review-button p-2"
            title="Submit Your Review">
            Submit Review
        </button> -->
</div>
</div>


<?php include 'footer.php'; ?> -->