$(function () {
    loadUsers();


    function loadUsers() {
        $.get('home/users', function (users) {
            console.log(users);
            (users.data).forEach(user => {
                var attribute = `<li id='li_${user.id}'>
            <img src="${user.image['240x240']}" onerror="src='public/img/user.png'">
            <p>
              <strong>${user.nama}</strong><br>
              <span>${user.alamat}</span>
            </p>
            <div>
              <a href='home/update/${user.id}' class="edit">
                <i class="fas fa-edit"></i>
              </a>
              <a class="remove" onclick='remove(${user.id})'>
                <i class="fas fa-trash-alt"></i>
              </a>
            </div>
          </li>`;
                $('#scroll').append(attribute);
            });
        });
    }


    function remove(id) {
        $.get('home/userdelete/' + id, function (user) {
            console.log(user);
            $('#li_' + id).remove();
        });
    }

    var $form = $("#form");
    var $formUpdate = $("#formUpdate");
    $.validator.addMethod("alphabet", function (value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z\s]*$/);
    });
    $.validator.addMethod("alphanumeric", function (value, element) {
        return this.optional(element) || /^[\w. ,]+$/i.test(value);
    });
    $.validator.addMethod("birthdate", function (value, element) {
        return this.optional(element) || /^(\d{4})(-)(([0-1]{1})([1-2]{1})|([0]{1})([0-9]{1}))(-)(([0-2]{1})([1-9]{1})|([3]{1})([0-1]{1}))$/.test(value);
    });
    $form.validate({
        rules: {
            name: {
                required: true,
                alphabet: true
            },
            email: {
                required: true,
                email: true
            },
            address: {
                required: true,
                alphanumeric: true
            },
            birthdate: {
                required: true,
                birthdate: true
            },
            image: {
                required: true
            }
        },
        messages: {
            name: "Only alphabet and spaces are allowed",
            email: "Please specify a valid email address",
            address: "Only alphanumeric are allowed",
            birthdate: "Only YYYY-MM-DD format are allowed",
            image: "Only jpg image allowed"
        }
    });

    $formUpdate.validate({
        rules: {
            name: {
                required: true,
                alphabet: true
            },
            email: {
                required: true,
                email: true
            },
            address: {
                required: true,
                alphanumeric: true
            },
            birthdate: {
                required: true,
                birthdate: true
            }
        },
        messages: {
            name: "Only alphabet and spaces are allowed",
            email: "Please specify a valid email address",
            address: "Only alphanumeric are allowed",
            birthdate: "Only YYYY-MM-DD format are allowed"
        }
    });

    $('#form').submit(function (event) {
        event.preventDefault();
        var form = $('#form')[0];
        var formData = new FormData(form);
        $.ajax({
            url: 'home/user',
            method: "POST",
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                $('#message').html('Saving Success...!');
                var thumbnail = 'public/img/user.png';
                $('#imagePreview').css('background-image', 'url(' + thumbnail + ')');
                $('#form').trigger('reset');
                var attribute = `<li id='li_${result.id}'>
            <img src="${result.thumbnail_2}" onerror="src='public/img/user.png'">
            <p>
              <strong>${result.name}</strong><br>
              <span>${result.address}</span>
            </p>
            <div>
            <a href='home/update/${result.id}' class="edit">
            <i class="fas fa-edit"></i>
            </a>
            <a class="remove" onclick='remove(${result.id})'>
            <i class="fas fa-trash-alt"></i>
            </a>
            </div>
          </li>`;
                $('#scroll').prepend(attribute);
            },
            error: function (er) {
                $('#message').html('Opps, Error...!');
            }
        });
    });

    $('#formUpdate').submit(function (event) {
        event.preventDefault();
        var form = $('#formUpdate')[0];
        var formData = new FormData(form);
        $.ajax({
            url: 'home/userupdate',
            method: "POST",
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (result) {
                $('#message').html('Updating Success...!');
            },
            error: function (er) {
                $('#message').html('Opps, Error...!');
            }
        });
    });

    $('#image').on('change', function () {
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return;
        if (/^image/.test(files[0].type)) {
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);

            reader.onloadend = function () {
                $('#imagePreview').css('background-image', 'url(' + this.result + ')');
            }
        }
    });
});