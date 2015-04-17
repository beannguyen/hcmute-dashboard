var Script = function () {

//    $.validator.setDefaults({
  //      submitHandler: function() { alert("submitted!"); }
   // });
    

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $().ready(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate();
        $('#formsettinguser').validate({
            rules: {
                email: {
                    email: true,
                }
            },
            messages: {
               
                email:{
                    email:"Email không đúng dạng"
                } 
            }
        });

        // validate signup form on keyup and submit
        $("#signupForm").validate({

            rules: {
                fullname:"required",
                firstname: "required",
                lastname: "required",
                username: {
                    required: true,
                    minlength: 2,
                    remote:{
                        url:"check/check-username",
                        type:"POST",
                    }
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true,
                    remote:{
                        url:"check/check-email",
                        type:"POST"
                    }
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                fullname:"Vui lòng nhập họ tên",
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                username: {
                    required: "Vui lòng nhập tên tài khoản",
                    minlength: "Tên tài khoản phải lớn hơn 2 kí tự",
                    remote:"Tài khoản đã tồn tại"
                },
                password: {
                    required: "Vui lòng nhập mật khẩu",
                    minlength: "Mật khẩu của bạn phải lớn hơn 5 kí tự"
                },
                confirm_password: {
                    required: "Vui lòng nhập lại mật khẩu",
                    minlength: "Mật khẩu phải lớn hơn 5 kí tự",
                    equalTo: "Mật khẩu nhập lại không đúng"
                },
                email:{
                    required:"Vui lòng nhập email",
                    email:"Email không đúng dạng",
                    remote:"Email đã tồn tại"
                } ,
                agree: "Please accept our policy"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();