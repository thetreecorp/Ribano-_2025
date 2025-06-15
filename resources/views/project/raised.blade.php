@inject('common', 'App\Http\Controllers\ProjectController')
{{-- @if($project->raising && $project->have_you_raised) --}}
    <?php 
       // $count_percent = $project->have_you_raised ?? 0;
        $count_percent = $project->investment_equity_grand ?? 0;
        
        $count_raising = (int)( $project->raising) ?  $project->raising : 1;
        $getPriceToken = 1;
        if($project->token)
            $getPriceToken = $project->token->token_price ? $project->token->token_price : 1;
        // if($common->sumToken($project->id))
        //     $count_percent = (float)$common->sumToken($project->id)*(float)$getPriceToken;
        $percent = (int)( (unformatNumber($count_percent)/unformatNumber($count_raising))*100);
        $percent = $percent < 100 ? $percent: 100;
    
            
    ?>
    <div class="raised">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-right single-progress">
            <div class="progress profile-complition text-right ">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: {{$percent}}%">
                    <span style="min-width:120px" class="sr-only">{{$percent}}% <span class="editableLabel" labelid="find_proposal:raised"> {{translate("Raised")}}</span><i class="down"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
{{-- @endif --}}