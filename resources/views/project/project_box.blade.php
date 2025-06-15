@inject('common', 'App\Http\Controllers\ProjectController')
<div class="project-card">
    <div class="card-banner">
        <div class="card-bg">
            <img class="bg-cover" src="{{$project->banner ? $common->getLinkIdrive($project->banner) : 'https://placehold.jp/1920x600.png' }}" alt="bg-cover">
        </div>
    </div>
    <div class="card-img">
        <div class="card-logo">
            <img alt="logo" src="{{$project->logo ? $common->getLinkIdrive($project->logo) : 'https://placehold.jp/86x86.png' }}" alt="project-logo">
        </div>
        
    </div>
    {{-- <div class="raised">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right single-progress">
            <div class="progress profile-complition text-right ">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                    <span style="min-width:120px" class="sr-only">80% <span class="editableLabel" labelid="find_proposal:raised"> Raised</span><i class="down"></i>
                    </span>
                </div>
            </div>
        </div>
    </div> --}}
    @include('project.raised', ['project' => $project])
    <div class="card-content">
        <a href="{{ route('viewProject', $project->slug) }}">
            <div class="card-title">
                <p><strong>{{$project->title ?? translate('N/A')}}</strong></p>
                <p><label>{{translate("Address")}}: </label> {{$project->country ?? translate('N/A')}} </p>
            </div>
        </a>
        <div class="project-description">
            <div class="summary">
                                
                @if($project->short_summary)
                    <div class="content-item">
                        <div class="desc-content ">
                            {!!excerptText($project->short_summary, 20)!!}
                        </div>
                    </div>
                    
                @endif
            </div>
            {{-- <div class="highlights">
                @if($project->highlights)
                    <div class="content-item">
                        <div class="desc-content">
                            <ul>
                                @foreach (explode('#%#', $project->highlights) as $val)
                                    <li>{{$val}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                @endif
            </div> --}}
            
            <div class="card-bottom">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <?php 
                            $count_raising = $project->raising ?? 'N/A';
                        ?>
                        <div class="bottom-raising">
                            <h6>{{$project->raising ? 'US$ ' .$project->raising : translate('N/A')}}</h6>
                            <span><span class="editableLabel" labelid="global:needed">{{translate("Target")}}</span></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="bottom-raising">
                            <h6>{{$project->minimum_equity_investment ? 'US$ ' . $project->minimum_equity_investment :  ''}}</h6>
                            <span><span class="editableLabel" labelid="global:needed">{{translate("Min per Investor")}}</span></span>
                        </div>
                    </div>
                    @if (isset($type) && $type == 'my-pitches')
                        <div class="active-buttons">
                            <a class="no-effect" href="{{ route('user.editProject', $project->slug) }}">
                                <span class="btn btn-primary">{{translate("Edit my Pitch")}}</span>
                            </a>
                            <a href="javasscript:void(0)"
                                class="ms-3 js-call-delete-pitch">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('viewProject', $project->slug) }}" class="btn btn-primary" target="_blank">{{translate("Find Out
                            More")}}</a>
                    @endif
                    
                </div>
            </div>
            
        </div>
    </div>
</div>