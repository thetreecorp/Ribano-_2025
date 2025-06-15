const UploadResizeWidth = 96;
const UploadResizeHeight = 96;
$(document).ready(function () {
    "use strict";
    $('#navbar_search').on('input', function () {
        var search = $(this).val().toLowerCase();
        var search_result_pane = $('#navbar_search_result_area .navbar_search_result');
        $(search_result_pane).html('');
        if (search.length == 0) {
            return;
        }

        var match = $('#sidebarnav .sidebar-link').filter(function (idx, element) {
            return $(element).text().trim().toLowerCase().indexOf(search) >= 0 ? element : null;
        }).sort();

        if (match.length == 0) {
            $(search_result_pane).append('<li class="text-muted">No search result found.</li>');
            return;
        }

        match.each(function (index, element) {
            var item_url = $(element).attr('href') || $(element).data('default-url');
            var item_text = $(element).text().replace(/(\d+)/g, '').trim();
            $(search_result_pane).append(`<li><a href="${item_url}">${item_text}</a></li>`);
        });
    });
    function showToast(message, timeout, type) {
        type = (typeof type === 'undefined') ? 'info' : type;
        toastr.options.timeOut = timeout;
        toastr.options.progressBar = true;
        toastr[type](message);
    }
    
    // Submit create xeedwallet
    
    $("form#create-xeedwallet-user").submit(function (e) {
        var formAction = $(this).attr("action");
        //some stuff...
        e.preventDefault();
        
        if($('#create-xeedwallet-user input[type="email"]').val() == '') {
            showToast('Email field must not be empty', 1000, 'error');
            return;
        }
        if($('#create-xeedwallet-user input[name="password"]').val() == '') {
            showToast('Password field must not be empty', 1000, 'error');
            return;
        }
        if($('#create-xeedwallet-user input[name="first_name"]').val() == '') {
            showToast('First nname field must not be empty', 1000, 'error');
            return;
        }
        if($('#create-xeedwallet-user input[name="last_name"]').val() == '') {
            showToast('Last name field must not be empty', 1000, 'error');
            return;
        }
        
        $.ajax({
            type: 'post',
            url: formAction,
            data: {
                'email' : $('input[name="email"]').val(),
                'password' : $('input[name="password"]').val(),
                'first_name' : $('input[name="first_name"]').val(),
                'last_name' : $('input[name="last_name"]').val(),
                '_token' : $('meta[name="csrf-token"]').attr('content'),
            
            },
            beforeSend: function(){
                showToast("Sending data...", 200, 'warning');
                
            },
            complete: function(){
                
            },
            success:function(data){
                
                if(data.code == 200) {
                    showToast(data.message, 1000, 'success');
                    window.location.replace(data.redirect);
                }
                else {
                    showToast(data.message, 1000, 'error');
                }
            },
            error: function(xhr, status, error) {
               
                showToast("Sorry, there was a problem with active", 1700, 'error');
            }
            
        });  
            
        //some other stuff...
    }); 

    
    $(document).on('click', '.set-xeedwallet-btn', function () {
        let project_id = $(this).attr('data-id');
        $('input[name="project-id"]').val(project_id);
        $('#set_xeedwallet').modal('show');
    });


    $("form#set-xeedwallet-form").submit(function (e) {
        var formAction = $(this).attr("action");
        //some stuff...
        e.preventDefault();
        
        
        $.ajax({
            type: 'post',
            url: formAction,
            data: {
                'project_id' : $('input[name="project-id"]').val(),
                'xeedwallet_id' : $('#xeedwallet-select').val(),
               
                '_token' : $('meta[name="csrf-token"]').attr('content'),
            
            },
            beforeSend: function(){
                showToast("Sending data...", 200, 'warning');
                
            },
            complete: function(){
                
            },
            success:function(data){
                
                if(data.code == 200) {
                    showToast(data.message, 1000, 'success');
                    location.reload();
                    
                }
                else {
                    showToast(data.message, 1000, 'error');
                }
            },
            error: function(xhr, status, error) {
               
                showToast("Sorry, there was a problem with active", 1700, 'error');
            }
            
        });  
            
        //some other stuff...
    }); 
    
    
    

    $("input#token_symbol").on({
        keydown: function(e) {
            if (e.which === 32)
            return false;
            },
            change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });

    function readFile() {
    
        if (!this.files || !this.files[0]) return;
        
            const FR = new FileReader();
            
            FR.addEventListener("load", function(evt) {
            document.querySelector("#imgb64").src = evt.target.result;
            document.querySelector("#b64").value = evt.target.result;
        });
        
        FR.readAsDataURL(this.files[0]);
    
    }
    // const el = document.getElementById('t_icon');
    // if (el) {
    //   el.addEventListener("change", readFile);
    // }
    //document.querySelector("#t_icon").addEventListener("change", readFile);

   

});
const el = document.getElementById('t_icon');
if(el){
    document.getElementById("t_icon").onchange = function () {
        let sourceImage = new Image();
        let reader = new FileReader();
        console.log(this.files[0]);
        reader.readAsDataURL(this.files[0]);
        sourceImage.onload = () => {
            // Create a canvas with the desired dimensions
            let canvas = document.createElement("canvas");
            const aspect = sourceImage.naturalWidth / sourceImage.naturalHeight;
            const width = Math.round(UploadResizeWidth * Math.max(1, aspect));
            const height = Math.round(UploadResizeHeight * Math.max(1, 1 / aspect));
            canvas.width = UploadResizeWidth;
            canvas.height = UploadResizeHeight;
            const ctx = canvas.getContext("2d");
            // Scale and draw the source image to the canvas
            ctx.imageSmoothingQuality = "high";
            ctx.fillStyle = "#fff";
            ctx.fillRect(0, 0, UploadResizeWidth, UploadResizeHeight);
            ctx.drawImage(
                sourceImage,
                (UploadResizeWidth - width) / 2,
                (UploadResizeHeight - height) / 2,
                width,
                height
            );
            
            // Convert the canvas to a data URL in PNG format
            const options = [
                canvas.toDataURL("image/jpeg", 0.92),
                // Disabling webp because it doesn't work on iOS.
                // canvas.toDataURL('image/webp', 0.92),
                canvas.toDataURL("image/png"),
            ];
            options.sort((a, b) => a.length - b.length);
            
            //console.log(options[0]);
            document.querySelector("#imgb64").src = options[0];
            document.querySelector("#b64").value = options[0];

        };
            
        reader.onload = function (event) {
            sourceImage.src = event.target.result;
        };
    }
}

function onFilesChange(f) {
    let sourceImage = new Image();
    let reader = new FileReader();
    
    reader.readAsDataURL(f[0]);
    
    sourceImage.onload = () => {
      // Create a canvas with the desired dimensions
      let canvas = document.createElement("canvas");
      const aspect = sourceImage.naturalWidth / sourceImage.naturalHeight;
      const width = Math.round(UploadResizeWidth * Math.max(1, aspect));
      const height = Math.round(UploadResizeHeight * Math.max(1, 1 / aspect));
      canvas.width = UploadResizeWidth;
      canvas.height = UploadResizeHeight;
      const ctx = canvas.getContext("2d");
    
      // Scale and draw the source image to the canvas
      ctx.imageSmoothingQuality = "high";
      ctx.fillStyle = "#fff";
      ctx.fillRect(0, 0, UploadResizeWidth, UploadResizeHeight);
      ctx.drawImage(
        sourceImage,
        (UploadResizeWidth - width) / 2,
        (UploadResizeHeight - height) / 2,
        width,
        height
      );
    
      // Convert the canvas to a data URL in PNG format
      const options = [
        canvas.toDataURL("image/jpeg", 0.92),
        // Disabling webp because it doesn't work on iOS.
        // canvas.toDataURL('image/webp', 0.92),
        canvas.toDataURL("image/png"),
      ];
      options.sort((a, b) => a.length - b.length);
    
      //this.handleChange("tokenIconBase64", options[0]);
    };
    
    reader.onload = function (event) {
      sourceImage.src = event.target.result;
      
      console.log(event.target.result);
    };
}

function showToastV2(message, timeout, type) {
    type = (typeof type === 'undefined') ? 'info' : type;
    toastr.options.timeOut = timeout;
    toastr.options.progressBar = true;
    toastr[type](message);
}