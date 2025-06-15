@extends($theme.'layouts.app', ['body_class' => 'my-pitches hide-top-section'])
@section('title',__('My Pitches'))

@section('content')

<!-- login_signup_area_start -->
<section class="my_pitches_area pd0">

    <div class="container">
        @include($theme.'partials.pitch-menu')
        
        <div class="content-pitch">
            <?php
            
                //dd($projects);
            ?>
            <div class="column-sm">
                <div class="row row-box" id="project-lists">
                    @if (count($projects))
                    @foreach ($projects as $project)
                    <div class="col-md-4 wow fadeInUp col-box">
                        @include('project.project_box', ['type' => 'my-pitches'])
                    </div>
                    @endforeach
                    @else
                    <p class="no-result">{{translate('No project found')}}</p>
                    @endif
                </div>
            </div>
            
            <div id="pagination-wrap">
                @if ($total > 12)
                <nav class="theme-pagination"></nav>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- login_signup_area_end -->
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{asset('public/assets/js/simplePagination.js')}}"></script>
<script src="{{ asset('public/assets/js/sweetalert2@11.js') }}"></script>
<script>
    
        
        // ajax run here
        function ajaxCall($page = 1, $updatePagination = true) {
			$.ajax({
		        type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        url: '{{route("searchProject")}}',
		        data: $('#seach-project-form').serialize()  + "&page=" + $page,
				beforeSend: function(){
					$('.loading-spin').html('<div class="loader">Loading...</div>');
			    },
			    complete: function(){
					$('.loading-spin').html('');
			    },
		        success: function(data) {

		            $('#project-lists').html(data.view);
		            $('.from-result').text(data.fromText);
		            $('.to-result').text(data.toText);
		            $('.total-result').text(data.total);
		            if($updatePagination) {
		                if(data.total > 12) {
			                // append pagenation
			                $('.theme-pagination').remove();
			                $('#pagination-wrap').append('<nav class="theme-pagination"></nav>');
							pagination(data.total);
			            }
			            else {
			                $('#pagination-wrap').html('');
			            }
		            }


		        }
		    });
		}
	    function pagination($total, $updatePagination = true){
	        $('.theme-pagination').pagination({
	            items: $total,
	            itemsOnPage: 12,
	            listStyle: 'pagination',
	            cssStyle: 'light-theme',

	            onPageClick: function(pageNumber) {
					$('html, body').animate({scrollTop: $('.top-title-project').offset().top - 200}, 500);
	                ajaxCall(pageNumber, false);
	                paged = localStorage.getItem('paged');
	                localStorage.setItem('paged', parseInt(paged) + 1);


	            }
	        });
	    }
        pagination({{$total}}, true);
        
        // Delete project
        $('.js-call-delete-pitch').on('click', function () {
                let id = $(this).attr('data-id');
                let url = $(this).attr('data-url');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // call ajax
                    $.ajax({
                        type: 'post',
                        url: "{{ route('user.deleteProject') }}",
                        data: {
                            'id' : id,
                            '_token' : $('meta[name="csrf-token"]').attr('content'),
                        
                        },
                        beforeSend: function(){
                           $(".js-call-delete-pitch").attr("disabled","disabled");
                        },
                        complete: function(){
                            
                        },
                        success:function(data){
                            $(".js-call-delete-pitch").attr("disabled","");
                            if(data.code == 200) {
                                Swal.fire({
                                    title: data.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    if (result.isConfirmed) {
            
                                        location.reload();
                                    }
                                })
                            }
                            else {
                                Swal.fire(
                                    'Error',
                                    data.message,
                                    'error'
                                );
                                $(".js-call-delete-pitch").attr("disabled","");
                                
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            Swal.fire(
                                'Error',
                                err,
                                'error'
                            );
                            $(".js-call-delete-pitch").attr("disabled","");
                        }
                        
                    });
               
                }
			});
        })
        
</script>
@endpush