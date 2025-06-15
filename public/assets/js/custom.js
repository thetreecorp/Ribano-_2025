$(".tab-link").click(function () {
    var tabID = $(this).attr("data-tab");
    $(this).addClass("active").siblings().removeClass("active");
    $("#tab-" + tabID)
        .addClass("active")
        .siblings()
        .removeClass("active");
});

(function () {
	$('.hamburger-menu').on('click', function() {
		$('.bar').toggleClass('animate');
        var mobileNav = $('.mobile-nav');
        mobileNav.toggleClass('hide show');
        $('.mobile').toggleClass('show');
	})
})();

var $element = $('#fixed-scroll-menu');

    if($element.length)
        $(window).scroll(function() {
            var scrollTop = $(this).scrollTop();
            var offset = $('#fixed-scroll-menu').offset().top;
            var distance = (offset - scrollTop);
            if (distance <= 0) {
                $('body').addClass('scrolled-to');
            } else {
                $('body').removeClass('scrolled-to');
            }
            var offsetFotter = $('.footer_area').offset().top - 250;
            var distanceB = (offsetFotter - scrollTop);
            if (distanceB <= 0) {
                $('body').removeClass('scrolled-to');
            }
        });
        
$(function(){
    $(".currencies-select select").change(function(){
      window.location= window.location.origin + '/currency/' + this.value
    });
    $(".country-select select").change(function(){
      window.location= window.location.origin + '/country/' + this.value
    });
    $(".language-select select").change(function(){
      window.location= window.location.origin + '/language/' + this.value
      //window.location= "http://localhost/investment_portal" + '/language/' + this.value
    });
});

function showToast(message, timeout, type) {
    type = (typeof type === 'undefined') ? 'info' : type;
    toastr.options.timeOut = timeout;
    toastr.options.progressBar = true;
    toastr[type](message);
}

$("form#request-active-email").submit(function (e) {
    var formAction = $(this).attr("action");
    //some stuff...
    e.preventDefault();
    
    $.ajax({
        type: 'post',
        url: formAction,
        data: {
            'email' : $('input[name="email"]').val(),
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
            }
            else {
                showToast(data.message, 1000, 'error');
            }
        },
        error: function(xhr, status, error) {
           
            showToast("Sorry, there was a problem, with send email", 1700, 'error');
        }
        
    });  
        
    //some other stuff...
}); 

$("form#frm-email-active").submit(function (e) {
    var formAction = $(this).attr("action");
    //some stuff...
    e.preventDefault();
    
    if($('#request-active-email input[type="email"]').val() == '') {
        showToast('Email field must not be empty', 1000, 'error');
        return;
    }
    
    $.ajax({
        type: 'post',
        url: formAction,
        data: {
            'type': 'email',
            'email' : $('input[name="email"]').val(),
            'otp_code' : $('input[name="email_otp_code"]').val(),
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
                location.href = '/login';
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

// phone

$(".send-active-phone-otp").click(function (e) {
    var formAction = $(this).closest('form').attr("action");

    //some stuff...
    e.preventDefault();
    
    if($('input[name="phone"]').val() == '') {
        showToast('Phone field must not be empty', 1000, 'error');
        return;
    }
    
    $.ajax({
        type: 'post',
        url: formAction,
        data: {
            'phone' : $('input[name="phone"]').val(),
            'type' : 'send-otp-to-phone',
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
                
            }
            else {
                showToast(data.message, 1000, 'error');
            }
        },
        error: function(xhr, status, error) {
           
            showToast("Sorry, there was a problem, with sent otp", 1700, 'error');
        }
        
    });  
        
    //some other stuff...
}); 

$("form#frm-phone-active").submit(function (e) {
    var formAction = $(this).attr("action");
    //some stuff...
    e.preventDefault();
    //get form action:
    var formAction = $(this).attr("action");
    
    if($('input[name="phone"]').val() == '') {
        showToast('Phone field field must not be empty', 1000, 'error');
        return;
    }
    if($('input[name="otp_code"]').val() == '') {
        showToast('Otp field must not be empty', 1000, 'error');
        return;
    }
    
    $.ajax({
        type: 'post',
        url: formAction,
        data: {
            'type': 'phone',
            'phone' : $('input[name="phone"]').val(),
            'otp_code' : $('input[name="otp_code"]').val(),
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
                location.href = '/login';
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

// shortlist investor
$(".shortlist-investor").click(function (e) {

    let formAction = $(this).closest('form').attr("action");
    let investor_id = $(this).attr('target-user');
    let self = $(this);
    
    self.addClass('pointer-events');
    $.ajax({
        type: 'post',
        url: formAction,
        data: {
            'investor_id' : investor_id,
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            'type' : self.attr('data-type')
        },
        beforeSend: function(){
            showToast("Sending data...", 200, 'warning');
            
        },
        complete: function(){
            
        },
        success:function(data){
            self.removeClass('pointer-events');
            if(data.code == 200) {
                showToast(data.message, 1500, 'success');
                
            }
            else {
                showToast(data.message, 1500, 'error');
            }
        },
        error: function(xhr, status, error) {
           self.removeClass('pointer-events');
            showToast("Sorry, there was a problem,", 1500, 'error');
        }
        
    });  
        
    //some other stuff...
}); 


// shortlist project
$(".add-project-shortlist").click(function (e) {

    let formAction = $(this).closest('form').attr("action");
    let project_id = $(this).attr('data-target');
    let self = $(this);
    self.addClass('pointer-events');
    $.ajax({
        type: 'post',
        url: formAction,
        data: {
            'project_id' : project_id,
            '_token' : $('meta[name="csrf-token"]').attr('content'),
            'type' : self.attr('data-type')
        
        },
        beforeSend: function(){
            showToast("Sending data...", 200, 'warning');
            
        },
        complete: function(){
            
        },
        success:function(data){
            self.removeClass('pointer-events');
            if(data.code == 200) {
                showToast(data.message, 1500, 'success');
                
            }
            else {
                showToast(data.message, 1500, 'error');
            }
        },
        error: function(xhr, status, error) {
           self.removeClass('pointer-events');
            showToast("Sorry, there was a problem,", 1500, 'error');
        }
        
    });  
        
    //some other stuff...
}); 

let currentTabId = 'invested'
let currentTabPanelId = 'invested-list'
const toggleTab = (id, tabId) => {
        let oldTab = document.querySelector(`#${currentTabId}`)
        let newTab = document.querySelector(`#${id}`)
        let oldTabPanel = document.querySelector(`#${currentTabPanelId}`)
        let newTabPanel = document.querySelector(`#${tabId}`)

        oldTab.classList.remove('bg-blue-600', 'text-white')
        oldTab.classList.add('text-blue-600', 'hover:text-gray-600')
        oldTabPanel.classList.add('hidden')

        newTab.classList.remove('text-blue-600', 'hover:text-gray-600')
        newTab.classList.add('bg-blue-600', 'text-white')
        newTabPanel.classList.remove('hidden')

        currentTabId = id
        currentTabPanelId = tabId
}
