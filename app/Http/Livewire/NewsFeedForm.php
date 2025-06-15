<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
class NewsFeedForm extends Component
{
    use WithFileUploads, Common;
  
    public $project_id, $user_id, $description, $action, $status;
    
    

    public function mount()
    {

        
    }

    public function render()
    {
        
        return view('livewire.newsfeed-form');
    }
   
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForm()
    {
        
        dd('fffff');
        
        // $this->validate([
        //     'images.*' => 'image|max:10240', // 10MB Max
        // ]);
        
        // $list_img = [];
        
        // if($this->images)
        //     foreach ($this->images as $img) {
        //         $obj = $img;
        //         if(!is_string($img) && $img != NULL)
        //             //$obj = $img->store('files/users/' . Auth::id(), 'public');
        //             $obj = $img->store('ribano.org/users/' . Auth::id(), 's3');
        //             // $this->photo->store('photos', 's3')
        //         array_push($list_img, $obj);
        //     }
 
        
        // $team_photo = [];
        
        // $accept = $hights = [];
        // if($this->accept_goods)
        //     array_push($accept, $this->accept_goods);
        // if($this->fixed_assets)
        //     array_push($accept, $this->fixed_assets);
        // if($this->accept_hires)
        //     array_push($accept, $this->accept_hires);
        // // custom section
        // $custom_section = [];
        // $this->name_section = $this->name_section ?? [];
        // if(count($this->name_section))
        //     foreach ($this->name_section as $key => $value) {
        //         $obj = [];
                
        //         array_push($obj, $this->name_section[$key] ?? NULL);
        //         array_push($obj, $this->content_section[$key] ?? NULL);
        //         array_push($custom_section, $obj);
                
        //     }
        
        // $add_financials = [];
        // $this->finance_year = $this->finance_year ?? [];
        // if(count($this->finance_year))
        //     foreach ($this->finance_year as $key => $value) {
        //         $obj = [];
        //         array_push($obj, $this->finance_year[$key] ?? NULL);
        //         array_push($obj, $this->finance_turnove[$key] ?? NULL);
        //         array_push($obj, $this->finance_profit[$key] ?? NULL);
                
                
        //         array_push($add_financials, $obj);
                
        //     }
        // //team member
        // $team_member = [];
        // if($this->team_name)
        //     foreach ($this->team_name as $key => $value) {
        //         $obj = [];
        //         $file = $this->avatar[$key];
        //         if(!is_string($this->avatar[$key]) && $this->avatar[$key] != NULL)
        //             //$file = $this->avatar[$key]->store('files/users/' . Auth::id(), 'public');
        //             $file = $this->avatar[$key]->store('ribano.org/users/' . Auth::id(), 's3');
        //         array_push($obj, $file);
        //         array_push($obj, $this->team_name[$key] ?? NULL);
        //         array_push($obj, $this->linkedin[$key] ?? NULL);
        //         array_push($obj, $this->position[$key] ?? NULL);
        //         array_push($obj, $this->bio[$key] ?? NULL);

        //         array_push($team_member, $obj);
                
        //     }
        
        // $project = Project::where('id', $this->project_id)->update([
        //     'title' => $this->title,
            
        //     'user_id' => Auth::id() ?? 0,
        //     'website' => $this->website,
        //     'located' => $this->located,
        //     'country' => $this->country,
        //     'mobile_number' => $this->mobile_number,
        //     'industry_1' => $this->industry_1,
        //     'industry_2' => $this->industry_2,
        //     'stage' => $this->stage,
        //     'ideal_investor_role' => $this->ideal_investor_role,
        //     'short_summary' => $this->short_summary,
        //     'the_business' => $this->the_business,
        //     'the_market' => $this->the_market,
        //     'progress_proof' => $this->progress_proof,
        //     'objectives_future' => $this->objectives_future,
        //     'custom_section' => $custom_section ? json_encode($custom_section) : NULL,
        //     'highlights' => $this->highlights ? implode('#%#', $this->highlights) : NULL,
        //     'equity_checked' => $this->equity_checked,
        //     'convertible_notes_checked' => $this->convertible_notes_checked,
        //     'raising' => $this->raising,
        //     'amount_of_investment' => $this->amount_of_investment,
        //     'investment_type' => $this->investment_type,
        //     'accept' => implode(',', $accept),
        //     'as_investments' => $this->as_investments,
        //     'purchase_price' => $this->purchase_price,
        //     'date_of_issuance' => $this->date_of_issuance ? date('Y-m-d', strtotime($this->date_of_issuance)) : NULL,
        //     'exercise_price' => $this->exercise_price,
        //     'exercise_date' => $this->exercise_date ? date('Y-m-d', strtotime($this->exercise_date)) : NULL,
        //     'discount' => $this->discount,
        //     'maturity_date' => $this->maturity_date ? date('Y-m-d', strtotime($this->maturity_date)) :NULL,
        //     'valuation_cap' => $this->valuation_cap,
        //     'previous_round_raise' => $this->previous_round_raise,
        //     'have_you_raised' => $this->have_you_raised,
        //     'minimum_investment' => $this->minimum_investment,
        //     'maximum_investment' => $this->maximum_investment,
        //     'add_financials' => $add_financials ? json_encode($add_financials) : NULL,
        //     'tags' => $this->tags,
        //     'team_overview' => $this->team_overview,
        //     'team_members' => $team_member ? json_encode($team_member) : NULL,
        //     'logo' => (!is_string($this->logo) && $this->logo != NULL) ?  $this->logo->store('ribano.org/users/' . Auth::id(), 's3') : $this->logo,
        //     'banner' => (!is_string($this->banner) && $this->banner != NULL) ? $this->banner->store('ribano.org/users/' . Auth::id(), 's3') : $this->banner,
        //     'images' => $list_img ? implode(',', $list_img) : NULL,
        //     'video_url' => $this->video_url ?? NULL,
        //     'business_plan' => (!is_string($this->business_plan) && $this->business_plan != NULL) ? $this->business_plan->store('ribano.org/users/' . Auth::id(), 's3') : $this->business_plan,
        //     'financials' => (!is_string($this->financials) && $this->financials != NULL) ? $this->financials->store('ribano.org/users/' . Auth::id(), 's3') : $this->financials,
        //     'pitch_deck' => (!is_string($this->pitch_deck) && $this->pitch_deck != NULL) ? $this->pitch_deck->store('ribano.org/users/' . Auth::id(), 's3') : $this->pitch_deck,
        //     'executive_summary' => (!is_string($this->executive_summary) && $this->executive_summary != NULL) ? $this->executive_summary->store('ribano.org/users/' . Auth::id(), 's3') : $this->executive_summary,
        //     'additional_documents' => (!is_string($this->additional_documents) && $this->additional_documents != NULL) ? $this->additional_documents->store('ribano.org/users/' . Auth::id(), 's3') : $this->additional_documents,
        //     'term' => $this->additional_documents,
        //     'status' => 1,
            
            
        // ]);
        
        // // Check new title update
        
        // // update slug
        // if(Str::slug($this->title) . '-' . $this->project_id != $this->slug)
        //     Project::where('id', $this->project_id)->update([
        //         'slug' => Str::slug($this->title) . '-' . $this->project_id
        //     ]);
  
        // $this->clearForm();

        // //$this->successMessage = 'Project edit successfully.';
  
        // $this->currentStep = 1;
        // session()->flash('message', 'Project edit successfully.');
        // redirect()->route('user.editProject', $this->slug);
    }
  
   
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function clearForm()
    {
        //$this->reset();
    }
}
