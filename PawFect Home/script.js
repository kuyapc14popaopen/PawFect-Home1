// When submit button is clicked
$('.next-page').click(function() {
    // Show the confirmation form
    $('.confirmation-form').show();
});

// When upload button is clicked
$('.imageUploadDiv .btn[type="submit"]').click(function() {
    // Show the confirmation form
    $('.confirmation-form').show();
});

// When confirm button in the confirmation form is clicked
$('.confirm-btn').click(function() {
    // Hide the confirmation form
    $('.confirmation-form').hide();
    // Call the function to post the ad
    postAd();
});

// When cancel button in the confirmation form is clicked
$('.cancel-btn').click(function() {
    // Hide the confirmation form
    $('.confirmation-form').hide();
    // Optionally, you can perform additional actions here
});

// Function to post the ad
function postAd() {
    // Your code to submit the form or trigger the post ad process
    $('#uploadImage').submit(); // Example: Submitting the form
}
