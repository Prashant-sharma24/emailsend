<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Business Registration Form</title>
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
</head>

<body>

	<!-- Container for the form -->
	<div class="container">
		<!-- Row for centering the form -->
		<div class="row justify-content-center">
			<!-- Column for the form -->
			<div class="col-md-8">
			<?php if($this->session->flashdata('success_msg')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $this->session->flashdata('success_msg'); ?>
    </div>
<?php endif; ?>

				<!-- Form title -->
				<h2 class="mt-3">Business Registration Form</h2>
				<form action="<?php echo base_url('save-registration'); ?>" method="post">

					<!-- Customer Type radio buttons -->
					<div class="mb-3">
						<label class="form-label">Customer Type</label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="customer_type" id="non_corporate" value="non_corporate" checked>
							<label class="form-check-label" for="non_corporate">Non-Corporate Customer</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="customer_type" id="corporate" value="corporate">
							<label class="form-check-label" for="corporate">Corporate Customer</label>
						</div>
					</div>

					<!-- Contact Person Name input -->
					<div class="mb-3">
						<label for="contact_person_name" class="form-label">Contact Person Name:</label>
						<input type="text" class="form-control" id="contact_person_name" name="contact_person_name" required>
					</div>

					<!-- Business Email Address input -->
					<div class="mb-3">
						<label for="business_email" class="form-label">Business Email Address:</label>
						<input type="email" class="form-control" id="business_email" name="business_email" required>
					</div>

					<!-- Contact Number input -->
					<div class="mb-3">
						<label for="contact_number" class="form-label">Contact Number:</label>
						<input type="tel" class="form-control" id="contact_number" name="contact_number" required>
					</div>

					<!-- Business Name input -->
					<div class="mb-3">
						<label for="business_name" class="form-label">Business Name:</label>
						<input type="text" class="form-control" id="business_name" name="business_name" required>
					</div>

					<!-- Address input -->
					<div class="mb-3">
						<label for="address" class="form-label">Address:</label>
						<textarea class="form-control" id="address" name="address" rows="3" required></textarea>
					</div>

					<!-- Country input -->
					<div class="mb-3">
						<label for="country" class="form-label">Country:</label>
						<input type="text" class="form-control" id="country" name="country" required>
					</div>

					<!-- State input -->
					<div class="mb-3">
						<label for="state" class="form-label">State:</label>
						<input type="text" class="form-control" id="state" name="state" required>
					</div>

					<!-- Zip Code input -->
					<div class="mb-3">
						<label for="zip_code" class="form-label">Zip Code:</label>
						<input type="text" class="form-control" id="zip_code" name="zip_code" required>
					</div>

					<!-- GST No input -->
					<div class="mb-3">
						<label for="gst_no" class="form-label">GST No:</label>
						<input type="text" class="form-control" id="gst_no" name="gst_no" required>
					</div>


					<div class="mb-3" id="corporate_business_name" style="display: none;">
						<label class="form-label">Select Corporate Business Name:</label>
						<select class="form-select" id="corporate_name" name="corporate_name" ></select>
					</div>
					<!-- Corporate Address Display -->
					<div class="mb-3" id="corporate_address_div" style="display: none;">
						<label class="form-label">Corporate Address:</label>
						<input type="text" class="form-control" id="corporate_address" name="corporate_address" readonly>
					</div>


					<div id="address_display"></div>
					<!-- Payment Option (Hidden by default) -->
					<div class="mb-3" id="payment_option" style="display: none;">
						<label class="form-label">Payment Option:</label><br>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment_option" id="location_head" value="location_head_will_pay" >
							<label class="form-check-label" for="location_head">Location Head will pay</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="payment_option" id="corporate_office" value="corporate_office_will_pay" >
							<label class="form-check-label" for="corporate_office">Corporate Office will pay</label>
						</div>
					</div>

					<!-- Save and Cancel buttons -->
					<div class="mb-3">
						<button type="submit" id="submit_btn" class="btn btn-primary">Save</button>
						<a href="#" class="btn btn-secondary">Cancel</a>
					</div>
				</form>
			</div> <!-- End of col-md-8 -->
		</div> <!-- End of row -->
	</div> <!-- End of container -->

	<!-- Include Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>
	<!-- Include jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- <script>
		$(document).ready(function() {
			// AJAX request to fetch corporate names
			$.ajax({
				url: '<?php echo base_url('business_registration/fetch_corporate_names'); ?>',
				type: 'GET',
				success: function(response) {
					console.log(response);
					// Populate the corporate names dropdown with fetched data
					var selectElement = $('#corporate_name');
					$.each(response, function(index, corporate) {
						selectElement.append($('<option>', {
							value: corporate.id,
							text: corporate.business_name
						}));
					});
					// Show the corporate names dropdown after populating options
					$('#corporate_business_name').show();
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});

			$(document).ready(function() {
				// Event listener for change in corporate name dropdown
				$('#corporate_name').on('change', function() {
					var selectedCorporateId = $(this).val(); // Get the selected corporate ID

					// AJAX request to fetch corporate address
					$.ajax({
						url: '<?php echo base_url('business_registration/fetch_corporate_address'); ?>',
						type: 'POST',
						data: {
							corporate_name_id: selectedCorporateId
						}, // Send the ID to the backend
						success: function(response) {
							// Display the fetched address in the input field
							$('#corporate_address').val(response);
							$('#corporate_address_div').show();
						},
						error: function(xhr, status, error) {
							console.error(error);
						}
					});
				});
			});
		});
	</script>

	<script>
		// Function to show or hide fields based on selected customer type
		function toggleFields() {
			var customerType = $('input[name="customer_type"]:checked').val();

			// Show or hide fields based on customer type
			if (customerType === 'corporate') {
				$('#corporate_business_name').show();
				$('#payment_option').show();
				$('#corporate_address_div').show();
			} else {
				$('#corporate_business_name').hide();
				$('#payment_option').hide();
				$('#corporate_address_div').hide();
			}
		}

		// Trigger toggleFields function on customer type change
		$('input[name="customer_type"]').on('change', function() {
			toggleFields();
		});

		// Trigger toggleFields function on page load
		$(document).ready(function() {
			toggleFields();
		});


		// Function to log selected value of corporate_name select element
	</script> -->
	<!-- <script>
		$(document).ready(function() {
			// Event listener for change in customer type radio buttons
			$('input[name="customer_type"]').on('change', function() {
				var customerType = $('input[name="customer_type"]:checked').val();

				if (customerType === 'corporate') {
					// If customer type is corporate, show corporate business name dropdown and address input
					$('#corporate_business_name').show();
					$('#corporate_address_div').show();
					$('#payment_option').show();
				} else {
					// If customer type is non-corporate, hide corporate business name dropdown and address input
					$('#corporate_business_name').hide();
					$('#corporate_address_div').hide();
					$('#payment_option').hide();
				}
			});

			// AJAX request to fetch corporate names
			$.ajax({
				url: '<?php echo base_url('business_registration/fetch_corporate_names'); ?>',
				type: 'GET',
				success: function(response) {
					// Populate the corporate names dropdown with fetched data
					var selectElement = $('#corporate_name');

					// First, add the default option
					selectElement.append($('<option>', {
						value: '',
						text: 'Select Corporate  Name' // Change this text as needed
					}));

					// Then, add the fetched options
					$.each(response, function(index, corporate) {
						selectElement.append($('<option>', {
							value: corporate.id,
							text: corporate.business_name
						}));
					});
				},

				error: function(xhr, status, error) {
					console.error(error);
				}
			});

			// Event listener for change in corporate name dropdown
			$('#corporate_name').on('change', function() {
				var selectedCorporateId = $(this).val(); // Get the selected corporate ID

				// AJAX request to fetch corporate address
				$.ajax({
					url: '<?php echo base_url('business_registration/fetch_corporate_address'); ?>',
					type: 'POST',
					data: {
						corporate_name_id: selectedCorporateId
					}, // Send the ID to the backend
					success: function(response) {
						// Display the fetched address in the input field
						$('#corporate_address').val(response);
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			});
		});
	</script> -->

	<script>
    $(document).ready(function() {
        // Custom form validation function
        function validateForm() {
            var customerType = $('input[name="customer_type"]:checked').val();
            if (customerType === 'corporate') {
                // If customer type is corporate, validate both corporate name and payment option
                var corporateName = $('#corporate_name').val();
                var paymentOption = $('input[name="payment_option"]:checked').val();
                if (corporateName === '' || paymentOption === undefined) {
                    // If either corporate name or payment option is not selected, show error message and return false
                    alert('Please select both Corporate Business Name and Payment Option.');
                    return false;
                }
            }
            // If all validations pass or customer type is non-corporate, return true
            return true;
        }

        // Event listener for form submission
        $('form').submit(function() {
            return validateForm(); // Call the validateForm function before submitting the form
        });

        // Event listener for change in customer type radio buttons
        $('input[name="customer_type"]').on('change', function() {
            var customerType = $('input[name="customer_type"]:checked').val();

            if (customerType === 'corporate') {
                // If customer type is corporate, show corporate business name dropdown and address input
                $('#corporate_business_name').show();
                $('#corporate_address_div').show();
                $('#payment_option').show();
            } else {
                // If customer type is non-corporate, hide corporate business name dropdown and address input
                $('#corporate_business_name').hide();
                $('#corporate_address_div').hide();
                $('#payment_option').hide();
            }
        });

        // AJAX request to fetch corporate names
        $.ajax({
            url: '<?php echo base_url('business_registration/fetch_corporate_names'); ?>',
            type: 'GET',
            success: function(response) {
                // Populate the corporate names dropdown with fetched data
                var selectElement = $('#corporate_name');

                // First, add the default option
                selectElement.append($('<option>', {
                    value: '',
                    text: 'Select Corporate Name' // Change this text as needed
                }));

                // Then, add the fetched options
                $.each(response, function(index, corporate) {
                    selectElement.append($('<option>', {
                        value: corporate.id,
                        text: corporate.business_name
                    }));
                });
            },

            error: function(xhr, status, error) {
                console.error(error);
            }
        });

        // Event listener for change in corporate name dropdown
        $('#corporate_name').on('change', function() {
            var selectedCorporateId = $(this).val(); // Get the selected corporate ID

            // AJAX request to fetch corporate address
            $.ajax({
                url: '<?php echo base_url('business_registration/fetch_corporate_address'); ?>',
                type: 'POST',
                data: {
                    corporate_name_id: selectedCorporateId
                }, // Send the ID to the backend
                success: function(response) {
                    // Display the fetched address in the input field
                    $('#corporate_address').val(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
</body>

</html>
