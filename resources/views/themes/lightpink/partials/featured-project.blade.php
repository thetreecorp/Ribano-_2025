@inject('common', 'App\Http\Controllers\ProjectController')
<?php $projects = $common->getProjectFeatured(); ?>
<section class="featured-project">
        
    <div class="container">
        <div class="top-title-project text-center">
            <h6 class="">{{translate("Find an investment opportunity that's right for you", null,false)}}</h6>
           
        </div>

        
        
        <div class="column-sm" >
            <div class="row row-box" id="project-lists">
                @if (($projects))
                    @foreach ($projects as $project)
                        <div class="col-md-4 wow fadeInUp col-box">
                            @include('project.project_box_home')
                        </div>
                    @endforeach
                @else
                    <p class="no-result">{{translate('No project found')}}</p>
                @endif
            </div>
        </div>

        
    </div>
    
    

</section>