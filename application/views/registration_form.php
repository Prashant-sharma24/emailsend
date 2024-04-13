<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
</head>

<body>

<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">

	    <h2 class="mt-3">Business Registration Form</h2>
    <?php if(isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_msg']; ?></div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>
    <form id="registration_form" method="post" action="<?php echo base_url('business_registration/save_registration'); ?>">
        <!-- Contact Person Name -->
        <div class="mb-3">
            <label for="contact_person_name" class="form-label">Contact Person Name</label>
            <input type="text" class="form-control" id="contact_person_name" name="contact_person_name" required>
        </div>

        <!-- Business Email Address -->
        <div class="mb-3">
            <label for="business_email" class="form-label">Business Email Address</label>
            <input type="email" class="form-control" id="business_email" name="business_email" required>
        </div>

        <!-- Contact Number -->
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="tel" class="form-control" id="contact_number" name="contact_number" required>
        </div>

        <!-- Business Name -->
        <div class="mb-3">
            <label for="business_name" class="form-label">Business Name</label>
            <input type="text" class="form-control" id="business_name" name="business_name" required>
        </div>

        <!-- Address -->
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>

        <!-- Country -->
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" required>
        </div>

        <!-- State -->
        <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>

        <!-- Zip Code -->
        <div class="mb-3">
            <label for="zip_code" class="form-label">Zip Code</label>
            <input type="text" class="form-control" id="zip_code" name="zip_code" required>
        </div>

        <!-- GST No -->
        <div class="mb-3">
            <label for="gst_no" class="form-label">GST No</label>
            <input type="text" class="form-control" id="gst_no" name="gst_no" required>
        </div>

        <!-- Customer Type -->
        <div class="mb-3">
            <label for="customer_type" class="form-label">Customer Type</label>
            <select class="form-select" id="customer_type" name="customer_type" required>
                <option value="non_corporate">Non-Corporate Customer</option>
                <option value="corporate">Corporate Customer</option>
            </select>
        </div>

        <!-- Corporate Business Name (Hidden by default) -->
        <div class="mb-3" id="corporate_business_name" style="display: none;">
            <label for="corporate_name" class="form-label">Select Corporate Business Name</label>
            <select class="form-select" id="corporate_name" name="corporate_name">
                <?php foreach ($corporate_customers as $corporate_customer): ?>
                    <option value="<?php echo $corporate_customer->id; ?>"><?php echo $corporate_customer->business_name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Payment Option (Hidden by default) -->
        <div class="mb-3" id="payment_option" style="display: none;">
            <label class="form-label">Payment Option</label><br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_option" id="location_head" value="location_head_will_pay">
                <label class="form-check-label" for="location_head">Location Head will pay</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_option" id="corporate_office" value="corporate_office_will_pay">
                <label class="form-check-label" for="corporate_office">Corporate Office will pay</label>
            </div>
        </div>

        <!-- Save and Cancel buttons -->
        <div class="mb-3">
            <button type="button" id="submit_btn" class="btn btn-primary">Save</button>
            <a href="#" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</div>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
<script>
    // Show/hide Corporate Business Name and Payment Option based on Customer Type selection
    document.getElementById('customer_type').addEventListener('change', function() {
        var corporate_business_name = document.getElementById('corporate_business_name');
        var payment_option = document.getElementById('payment_option');

        if (this.value === 'corporate') {
            corporate_business_name.style.display = 'block';
            payment_option.style.display = 'block';
        } else {
            corporate_business_name.style.display = 'none';
            payment_option.style.display = 'none';
        }
    });

    // Form validation and submission
    document.getElementById('submit_btn').addEventListener('click', function() {
        if (validateForm()) {
            document.getElementById('registration_form').submit();
        }
    });

    // Form validation function
    function validateForm() {
        var contact_person_name = document.getElementById('contact_person_name').value.trim();
        var business_email = document.getElementById('business_email').value.trim();
        var contact_number = document.getElementById('contact_number').value.trim();
        var business_name = document.getElementById('business_name').value.trim();
        var address = document.getElementById('address').value.trim();
        var country = document.getElementById('country').value.trim();
        var state = document.getElementById('state').value.trim();
        var zip_code = document.getElementById('zip_code').value.trim();
        var gst_no = document.getElementById('gst_no').value.trim();
        var customer_type = document.getElementById('customer_type').value;

        if (contact_person_name === '' || business_email === '' || contact_number === '' || business_name === '' || address === '' || country === '' || state === '' || zip_code === '' || gst_no === '') {
            alert('All fields are required.');
            return false;
        }

        if (customer_type === 'corporate') {
            var payment_option = document.querySelector('input[name="payment_option"]:checked');
            if (!payment_option) {
                alert('Please select a payment option.');
                return false;
            }
        }

        return true;
    }
</script>
</body>
</html>
