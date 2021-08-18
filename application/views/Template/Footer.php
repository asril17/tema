<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="<?= base_url() ?>Assets/js/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- <script src="<?= base_url() ?>Assets/js/jquery-validation/jquery.validate.js"></script> -->
<script src="<?= base_url() ?>Assets/jquery.validate.min.js"></script>
<script src="<?= base_url() ?>Assets/js/format_rp.js"></script>
<script>
    $(document).on('keyup', '#search', function() {
        let keyword = $(this).val();
        // alert(keyword)

        $.ajax({
            url: '<?php echo base_url() . "Product/search" ?>',
            method: "POST",
            dataType: "json",
            data: {
                keyword: keyword
            },
            beforeSend: function() {
                $('#list').html('<h6 class="text-center">Loading...</h6>');
            },
            success: function(res) {
                console.log(res.transaction);
                let data = res.transaction
                if (data.length > 0) {
                    $('#list').html(reload(data));
                    $('#pag').html(res.pagination);
                } else {
                    $('#pag').html('');
                    $('#list').html('<h6 class="text-center">Not Found</h6>');

                }
            }

        });

    });

    $(document).on('click', '.pagi', function() {
        let href = $(this).attr('href');
        let val = href.replace('#', '');
        let url = $(this).data('link') + "/" + val;

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $('#list').html('<h6 class="text-center">Loading...</h6>');
            },
            success: function(res) {
                let data = res.transaction
                if (data.length > 0) {
                    $('#list').html(reload(data));
                    $('#pag').html(res.pagination);
                } else {
                    $('#pag').html('');
                    $('#list').html('<h6 class="text-center">Not Found</h6>');

                }
            }

        });

    });

    function reload(data) {
        let txt = '';
        $.each(data, function(index, val) {

            txt += '<li class="list-group-item">';
            txt += '<div class="row">';
            txt += '<div class="col">';
            txt += '<div class="order-total">';
            txt += '<h6>' + val.order_no + '</h6>';
            txt += '<h6>' + format_rp(val.total) + '</h6>';
            txt += '</div>';
            if (val.transaction_type == 'Prepaid Balance') {
                txt += '<p>' + format_rp(val.value) + ' for ' + val.mobile_number + '</p>';
            } else {
                txt += '<p>' + val.product + ' that costs ' + format_rp(val.price) + '</p>';
            }
            txt += '</div>';
            txt += '<div class="col-3">';
            txt += '<div class="list-button">';

            if (val.transaction_type == 'Prepaid Balance') {
                if (val.status == 'Created') {

                    txt += '<a href="<?= base_url('Product/payOrder/') ?>' + val.id_transaction + '" class="btn btn-sm btn-primary">Pay now</a>';
                } else if (val.status == 'Success') {
                    txt += '<h6 class="text-success">' + val.status + '</h6>';
                } else if (val.status == 'Failed') {
                    txt += '<h6 class="text-orange">' + val.status + '</h6>';
                } else if (val.status == 'Canceled') {
                    txt += '<h6 class="text-danger">' + val.status + '</h6>';
                } else {
                    txt += '<h6>' + val.status + '</h6>';
                }

            } else {
                if (val.status == 'Created') {
                    txt += '<a href="<?= base_url('Product/payOrder/') ?>' + val.id_transaction + '" class="btn btn-sm btn-primary">Pay now</a>';
                } else if (val.status == 'Success') {
                    txt += '<h6>' + val.shipping_code + '</h6>';

                } else {
                    txt += '<h6 class="text-danger">' + val.status + '</h6>';
                }
            }


            // txt += '<a href="" class="btn btn-sm btn-primary">Pay now</a>';
            txt += '</div>';
            txt += '</div>';
            txt += '</div>';
            txt += '</li>';

        });
        return txt;
    }
    $(document).ready(function() {
        $('#form-register').validate({
            ignore: [],
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            rules: {
                nama: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                nama: {
                    required: "Nama is required"
                },
                email: {
                    required: "Email is required",
                    email: "Email is not valid"

                },
                password: {
                    required: "Password is required",
                    minlength: "Please enter at least 6 characters"
                }
            }
        });

        $('#form-login').validate({
            ignore: [],
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                email: {
                    required: "Email is required",
                    email: "Email is not valid"

                },
                password: {
                    required: "Password is required",
                    minlength: "Please enter at least 6 characters"
                }
            }
        });




        $('#form-prepaidBalance').validate({
            ignore: [],
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            rules: {
                mobileNumber: {
                    required: true,
                    digits: true,
                    minlength: 7,
                    maxlength: 12
                },
                value: {
                    required: true
                }
            },
            messages: {
                mobileNumber: {
                    required: "Mobile Number is required",
                    digits: "Only digits",
                    minlength: "Minimal length is 7",
                    maxlength: "Maximal length is 12"

                },
                value: {
                    required: "Value is required",
                }
            }
        });
        $('#form-product').validate({
            ignore: [],
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            rules: {
                namaProduct: {
                    required: true,
                    minlength: 10,
                    maxlength: 150
                },
                shippingAddress: {
                    required: true,
                    minlength: 10,
                    maxlength: 150
                },
                price: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                namaProduct: {
                    required: "Product name is required",
                    minlength: "Enter your Product name 10-150 characters",
                    maxlength: "Enter your Product name 10-150 characters"

                },
                shippingAddress: {
                    required: "Shipping address is required",
                    minlength: "Enter your Shipping address 10-150 characters",
                    maxlength: "Enter your Shipping address 10-150 characters"
                },
                price: {
                    required: "Price is required",
                    digits: "Digit only"
                }
            }
        });

        $('#sumbitPrepaid').on('click', function() {
            let val = $('#mobileNumber').val()
            let char = val.substr(0, 3)
            if (val.length >= 3 && char != '081') {
                // alert('masda')
                $('#mobileNumber').closest('.form-group').find('.error').remove()
                $('#mobileNumber').addClass('is-invalid')
                $('#mobileNumber').closest('.form-group').append('<label id="mobileNumber-error" class="error" for="mobileNumber" style="">Must be prefixed "081"</label>')
                // $('#form-prepaidBalance').submit()
            } else {
                $('#form-prepaidBalance').submit()
            }

        })

        $(document).on('keyup', '#mobileNumber', function() {
            this.value = this.value.replace(/[^0-9\.]/g, '');
            let val = this.value
            let char = val.substr(0, 3)
            if (val.length >= 3 && char != '081') {
                $(this).closest('.form-group').find('.error').remove()
                $(this).addClass('is-invalid')
                $(this).closest('.form-group').append('<label id="mobileNumber-error" class="error" for="mobileNumber" style="">Must be prefixed "081"</label>')

            }
        });



    });
</script>

</body>

</html>