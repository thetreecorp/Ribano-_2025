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
class EditProject extends Component
{
    use WithFileUploads, Common;
    public $currentStep = 1;
    public $title, $website = "https://", $located, $phone_code, $country, $mobile_number, $short_summary, $tags;
    public $industry_1, $industry_2, $stage, $ideal_investor_role, $the_business, $the_market, $progress_proof;
    public $objectives_future, $custom_section;
    public $section = 1, $i = 1, $j = 1, $c_investment = 1, $c_question = 1, $name_section = [], $content_section = [], $finance_year = [], $finance_turnove = [], $finance_profit = [];
    public $new_sections = [], $highlights = [], $amount, $equity_checked, $convertible_notes_checked, $raising, $amount_of_investment;
    public $investment_type, $as_investments, $accept_goods, $fixed_assets, $accept_hires, $purchase_price;
    public $date_of_issuance, $exercise_price, $exercise_date, $discount, $maturity_date, $valuation_cap;
    public $previous_round_raise, $have_you_raised, $minimum_investment, $maximum_investmeobjectives_future_titlent, $financial_sections = [];
    public $show_equity = false, $show_convertible =  false;
    public $team_overview, $avatar = [], $team_name = [], $linkedin = [], $position = [], $bio = [], $team_members = [];
    public $logo, $banner, $images = [], $images_edit = [], $video_url, $business_plan, $financials, $pitch_deck;
    public $executive_summary, $additional_documents, $term, $tagInput, $add_investments_title, $add_investments_value, $add_investments = [];
    public $successMessage = '', $taskduedate, $tag_test, $slug, $is_edit = true, $project_id;
    public $token_name = '', $token_symbol , $total_supply = 1000000000, $token_decimals = 18, $owner_account_id, $token_icon;
    public $image, $existingImages = [], $question_answers = [], $question, $answer;
    public $total_share, $price_of_share, $shares_granted, $total_investment = 0;
    
    public $summary_title, $business_title, $additional_documents_name, $the_market_title, $progress_proof_title, $objectives_future_title;
    public $errorMessage, $c_video = 1, $list_videos = [], $c_document = 1, $video_item, $add_documents = [], $add_document_name, $add_document_file;

    public $video_title, $video_description, $investment_grand, $investor_numbers, $v_title, $v_description, $v_item, $safe_target;
    public $investment_equity_grand, $investor_equity_numbers, $minimum_equity_investment, $maximum_equity_investment, $investment_equity_previous_rounds;

    // pagination
    public $perPage = 12;
    public $currentPage = 1;
    public $dataImages = [];
    public $totalPage = 0;
    public function mount($slug)
    {

        $this->slug = $slug;
        $findProject = Project::where('slug', $this->slug)->first();
        $this->project_id = $findProject->id;
       
        $hight_lights = $findProject->highlights;
       
        if($hight_lights) {
            $hight_lights = explode('#%#', $hight_lights);
            $this->highlights = $hight_lights;
        }
        
        if($findProject->images) {
            $l_images = explode('%###%', $findProject->images);
            //$this->images = $l_images;
            $this->existingImages = $l_images;
            $this->dataImages = $l_images;
            $this->totalPage = count($l_images);
        }
        
        if($findProject->convertible_notes_checked == 1)
            $this->show_convertible = true;
        if($findProject->equity_checked == 1)
            $this->show_equity = true;


        if($findProject->custom_section) {
            $custom_section = json_decode($findProject->custom_section, true);
            
            $array_name_section = $array_content_section = [];
            $final_array = [];
            foreach ($custom_section as $key => $value) {
                array_push($array_name_section, key_exists(0, $value) ? $value[0] : NULL);
                array_push($array_content_section, key_exists(1, $value) ? $value[1] : NULL);

                $final_array[$key] = $key;
            }
            $this->name_section = $array_name_section;
            $this->content_section = $array_content_section;

            
            $this->new_sections = $final_array;
            $this->section = count($custom_section);
            
        }

        //dd($findProject->as_investments);
        
        if(is_numeric(unformatNumber($findProject->as_investments)))
            $this->total_investment = unformatNumber($findProject->as_investments);

        if($findProject->add_more_investment) {
            $add_more_investment = json_decode($findProject->add_more_investment, true);

            $array_name_section = $array_content_section = [];
            $final_array = [];
            foreach ($add_more_investment as $key => $value) {
                array_push($array_name_section, key_exists(0, $value) ? $value[0] : NULL);
                array_push($array_content_section, key_exists(1, $value) ? n_format($value[1]) : NULL);

                $final_array[$key] = $key;
                
                if (is_numeric(unformatNumber($value[1]))) {
                    $this->total_investment += floatval(unformatNumber($value[1]));
                }
            }
            $this->add_investments_title = $array_name_section;
            $this->add_investments_value = $array_content_section;
            
            
            $this->add_investments = $final_array;
            $this->c_investment = count($add_more_investment);
            
        }
        
        // question answer
        if($findProject->question_answer) {
            $question_answer = json_decode($findProject->question_answer, true);

            $array_question_section = $array_answer_section = [];
            $final_array = [];
            foreach ($question_answer as $key => $value) {
                array_push($array_question_section, key_exists(0, $value) ? $value[0] : NULL);
                array_push($array_answer_section, key_exists(1, $value) ? $value[1] : NULL);

                $final_array[$key] = $key;
            }
            $this->question = $array_question_section;
            $this->answer = $array_answer_section;
            
            
            $this->question_answers = $final_array;
            $this->c_question = count($question_answer);
            
        }
        
        
        // accept
        $accept_db = explode(',', $findProject->accept);
        if(in_array('Goods', $accept_db)) {
            $this->accept_goods = 'Goods';
        }
        if(in_array('Fixed assets', $accept_db)) {
            $this->fixed_assets = 'Fixed assets';
        }
        if(in_array('Hires', $accept_db)) {
            $this->accept_hires = 'Hires';
        }
        
        
        
     
        
        if($findProject->add_financials) {
            $add_financials_section = json_decode($findProject->add_financials, true);
            

            $array_finance_year = $array_finance_turnove = $array_finance_profit = $final_array = [];
            $final_array = [];
            foreach ($add_financials_section as $key => $value) {
            
                array_push($array_finance_year, key_exists(0, $value) ? $value[0] : NULL);
                array_push($array_finance_turnove, key_exists(1, $value) ? $value[1] : NULL);
                array_push($array_finance_profit, key_exists(2, $value) ? $value[2] : NULL);

                $final_array[$key] = $key;
            }
            $this->finance_year = $array_finance_year;
            $this->finance_turnove = $array_finance_turnove;
            $this->finance_profit = $array_finance_profit;
            
      
            
            $this->financial_sections = $final_array;
            $this->i = count($add_financials_section);
            
        }
        // custom field
        if($findProject->add_video) { 
            $add_video_section = json_decode($findProject->add_video, true);
            

            $array_video = $video_item = $video_title = $video_description = $count_files = [];
            
            $this->list_videos = $add_video_section;
            foreach ($add_video_section as $key => $value) {
            


                array_push($video_item, key_exists(0, $value) ? $value[0] : NULL);
                array_push($video_title, key_exists(1, $value) ? $value[1] : NULL);
                array_push($video_description, key_exists(2, $value) ? $value[2] : NULL);

                $count_files[$key] = $key;
            }
            $this->list_videos = $count_files;
            $this->v_item = $video_item; // url
            $this->v_title = $video_title;
            $this->v_description = $video_description;
            $this->c_video = count($add_video_section);
            
          
            
           
        }

        if($findProject->more_documents) { 
            $add_document_section = json_decode($findProject->more_documents, true);
            
            
            //dd($add_document_section);
            
            $add_document_name = $add_document_file = $count_files = [];

            foreach ($add_document_section as $key => $value) {
            
                array_push($add_document_file, key_exists(0, $value) ? $value[0] : NULL);
                array_push($add_document_name, key_exists(1, $value) ? $value[1] : NULL);
               
                $count_files[$key] = $key;
            }
            $this->add_document_file = $add_document_file;
            $this->add_document_name = $add_document_name;

            

            
            
            $this->add_documents = $count_files;
            
            //dd($this->add_document_file);
            
            $this->c_document = count($add_document_section);
        
        }
        
        
        
        
        if($findProject->team_members) {

            $is_edit = 1;
            $team_members_section = json_decode($findProject->team_members, true);
            

            $array_avatar = $array_team_name = $array_linkedin = $array_position = $array_bio = $count_members = [];
            
            foreach ($team_members_section as $key => $value) {
            
                array_push($array_avatar, key_exists(0, $value) ? $value[0] : NULL);
                array_push($array_team_name, key_exists(1, $value) ? $value[1] : NULL);
                array_push($array_linkedin, key_exists(2, $value) ? $value[2] : NULL);
                array_push($array_position, key_exists(3, $value) ? $value[3] : NULL);
                array_push($array_bio, key_exists(4, $value) ? $value[4] : NULL);

                $count_members[$key] = $key;
            }
            $this->avatar = $array_avatar;
            $this->team_name = $array_team_name;
            $this->linkedin = $array_linkedin;
            $this->position = $array_position;
            $this->bio = $array_bio;
            
            
            $this->team_members = $count_members;
            $this->j = count($team_members_section);
            
        }
        
 
        
       
        $this->title = $findProject->title;
        $this->website = $findProject->website;
        $this->located = $findProject->located;
        $this->country = $findProject->country;
        $this->mobile_number = $findProject->mobile_number;
        $this->industry_1 = $findProject->industry_1;
        $this->industry_2 = $findProject->industry_2;
        $this->stage = $findProject->stage;
        $this->ideal_investor_role = $findProject->ideal_investor_role;
        
        $this->summary_title = $findProject->summary_title;
        $this->short_summary = $findProject->short_summary;
        $this->business_title = $findProject->business_title;
        $this->the_business = $findProject->the_business;
        $this->the_market_title = $findProject->the_market_title;
        $this->the_market = $findProject->the_market;
        $this->progress_proof_title = $findProject->progress_proof_title;
        $this->progress_proof = $findProject->progress_proof;
        $this->objectives_future_title = $findProject->objectives_future_title;
        $this->objectives_future = $findProject->objectives_future;
       // $this->custom_section = $custom_section ? json_encode($custom_section) : NULL;
        //$this->highlights = $findProject->highlights ? implode(',', $findProject->highlights) : NULL;
        $this->equity_checked = $findProject->equity_checked;
        $this->convertible_notes_checked = $findProject->convertible_notes_checked;
        $this->investment_grand = $findProject->investment_grand;
        $this->investor_numbers = $findProject->investor_numbers;
        
        
        $this->safe_target = n_format($findProject->safe_target);
        $this->investment_equity_grand = n_format($findProject->investment_equity_grand);
        $this->investor_equity_numbers = n_format($findProject->investor_equity_numbers);
        $this->minimum_equity_investment = n_format($findProject->minimum_equity_investment);
        $this->maximum_equity_investment = n_format($findProject->maximum_equity_investment);
        $this->investment_equity_previous_rounds = $findProject->investment_equity_previous_rounds;

        $this->raising = n_format($findProject->raising);
        $this->amount_of_investment = $findProject->amount_of_investment;
        $this->investment_type = $findProject->investment_type;
      //  $this->accept = implode(',', $accept);
        $this->as_investments = n_format($findProject->as_investments);

        $this->total_share = $findProject->total_share;
        $this->price_of_share = $findProject->price_of_share;
        $this->shares_granted = $findProject->shares_granted;


        
        $this->purchase_price = $findProject->purchase_price;
        $this->date_of_issuance = $findProject->date_of_issuance ? date('Y-m-d', strtotime($findProject->date_of_issuance)) : NULL;
        $this->exercise_price = $findProject->exercise_price;
        $this->exercise_date = $findProject->exercise_date ? date('Y-m-d', strtotime($findProject->exercise_date)) : NULL;
        $this->discount = $findProject->discount;
        $this->maturity_date = $findProject->maturity_date ? date('Y-m-d', strtotime($findProject->maturity_date)) :NULL;
        $this->valuation_cap = $findProject->valuation_cap;
        $this->previous_round_raise = $findProject->previous_round_raise;
        $this->have_you_raised = $findProject->have_you_raised;
        $this->minimum_investment = $findProject->minimum_investment;
        $this->maximum_investment = $findProject->maximum_investment;
        //$this->add_financials = $add_financials ? json_encode($add_financials) : NULL;
        $this->tags = array_filter(explode('%###%', $findProject->tags));
        
        $this->team_overview = $findProject->team_overview;
        //$this->team_members = $team_member ? json_encode($team_member) : NULL;
        $this->logo = $findProject->logo ??  NULL;
        $this->banner = $findProject->banner ??  NULL;
       // $this->images = $list_img ? implode(',', $list_img) : NULL;
        $this->video_url = $findProject->video_url ?? NULL;
        $this->video_title = $findProject->video_title ?? NULL;
        $this->video_description = $findProject->video_description ?? NULL;
        $this->business_plan = $findProject->business_plan ?? NULL;
        $this->financials = $findProject->financials ?? NULL;
        $this->pitch_deck = $findProject->pitch_deck ?? NULL;
        $this->executive_summary = $findProject->executive_summary ?? NULL;
        $this->additional_documents = $findProject->additional_documents ?? NULL;
        $this->additional_documents_name = $findProject->additional_documents_name ?? NULL;
        $this->term = $findProject->additional_documents;
        
        // $this->token_name = $findProject->token_name;
        // $this->token_symbol = $findProject->token_symbol;
        // $this->total_supply = $findProject->total_supply;
        // $this->token_decimals = $findProject->token_decimals;
        // $this->token_icon = ($findProject->token_icon);
    }

    

    public function deleteExistImage($index)
    {
        if ($index < count($this->existingImages)) {
    
            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);
        } 
      
    }
    public function deleteTempImage($index)
    {
        if ($index < count($this->images)) {
            $newImageIndex = $index ;
            unset($this->images[$newImageIndex]);
            $this->images = array_values($this->images);
        }
        
        
    }

    public function uploadImages()
    {

        $this->images[] = $this->image;
    
        $this->existingImages = array_merge($this->existingImages, $this->images);
    
        $this->image = null;
    }

    public function removePhoto($index)
    {
        unset($this->images[$index]);
    }

    public function addQuestion($section)
    {
        $section = $section + 1;
        $this->c_question = $section;
        array_push($this->question_answers ,$section);
    }

    public function removeQuestion($section)
    {
        unset($this->question_answers[$section]);
    }

    public function addTag()
    {
        if ($this->tagInput !== '') {
            if (!in_array($this->tagInput, $this->tags)) {
                $this->tags[] = $this->tagInput;
            }
            $this->tagInput = '';
        }
    }

    // update format number



    public function updatedTotalShare()
    { 
       
        $this->total_share = n_format($this->total_share);
    }
    public function updatedSharesGranted()
    { 
        $this->shares_granted = n_format($this->shares_granted);
    }
    public function updatedRaising()
    { 
        $this->raising = n_format($this->raising);
    }
    public function updatedInvestmentEquityPreviousRounds()
    { 
       
        $this->investment_equity_previous_rounds = n_format($this->investment_equity_previous_rounds);
    }
    public function updatedInvestmentEquityGrand()
    { 
       
        $this->investment_equity_grand = n_format($this->investment_equity_grand);
    }
    public function updatedInvestorEquityNumbers()
    { 
       
        $this->investor_equity_numbers = n_format($this->investor_equity_numbers);
    }
    public function updatedMinimumEquityInvestment()
    { 
       
        $this->minimum_equity_investment = n_format($this->minimum_equity_investment);
    }
    public function updatedMaximumEquityInvestment()
    { 
       
        $this->maximum_equity_investment = n_format($this->maximum_equity_investment);
    }

    
    // SAFE 
    public function updatedSafeTarget()
    { 
        $this->safe_target = n_format($this->safe_target);
    }
    
    public function updatedPurchasePrice()
    { 
        // $this->purchase_price = n_format($this->purchase_price);
    }
    
    public function updatedExercisePrice()
    { 
        $this->exercise_price = n_format($this->exercise_price);
    }
    
    public function updatedDiscount()
    { 
        $this->discount = n_format($this->discount);
    }
    
    public function updatedValuationCap()
    { 
        $this->valuation_cap = n_format($this->valuation_cap);
    }
    
    public function updatedPreviousRoundRaise()
    { 
        $this->previous_round_raise = n_format($this->previous_round_raise);
    }
    
    public function updatedHaveYouRaised()
    { 
        $this->have_you_raised = n_format($this->have_you_raised);
    }
    
    public function updatedInvestmentGrand()
    { 
        $this->investment_grand = n_format($this->investment_grand);
    }

    public function updatedInvestorNumbers()
    { 
        $this->investor_numbers = n_format($this->investor_numbers);
    }
    public function updatedMinimumInvestment()
    { 
        $this->minimum_investment = n_format($this->minimum_investment);
    }
    
    public function updatedMaximumInvestment()
    { 
        $this->maximum_investment = n_format($this->maximum_investment);
    }


    public function updatedFinanceProfit()
    {

        foreach ($this->finance_profit as $key => $value) {
           // if (is_numeric($value)) {
                $this->finance_profit[$key] = n_format($value);
           // }
        }
        
        $this->updateTotal();
    }
    
    

    public function removeTag($tag)
    {
        $this->tags = array_diff($this->tags, [$tag]);
    }

    public function addInvestment($i)
    {
        $c_investment = $i + 1;
        $this->c_investment = $i;
        array_push($this->add_investments ,$i);
    }
    public function removeInvestment($i)
    {
        unset($this->add_investments[$i]);
        $this->updateTotal();
    }

    public function updatedAddInvestmentsValue()
    {
        // update format
        foreach ($this->add_investments_value as $key => $value) {
           // if (is_numeric($value)) {
                $this->add_investments_value[$key] = n_format($value);
           // }
        }
        
        $this->updateTotal();
    }
    public function updatedAsInvestments()
    {
        
        if (is_numeric(unformatNumber($this->as_investments)) && empty($this->add_investments_value))
            $this->total_investment = floatval(unformatNumber($this->as_investments));
        else {
            $this->total_investment = 0;
            foreach ($this->add_investments_value as $value) {
                if (is_numeric(unformatNumber($value))) {
                    $this->total_investment += floatval(unformatNumber($value));
                }
            }
        }
        $this->as_investments = n_format($this->as_investments);
        $this->total_investment = floatval($this->total_investment) + floatval(unformatNumber($this->as_investments));
        
    }

    private function updateTotal()
    {
        $this->total_investment = 0;

        foreach ($this->add_investments_value as $value) {
            if ((is_numeric(unformatNumber($value)))) {
                $this->total_investment += floatval(unformatNumber($value));
            }
        }
        
        if(is_numeric(unformatNumber($this->as_investments)))
            $this->total_investment = floatval(unformatNumber($this->total_investment)) + floatval(unformatNumber($this->as_investments));
    
    }

    public function render()
    {
        $currentPageData = [];
        if($this->dataImages)
            $currentPageData = array_chunk($this->dataImages, $this->perPage)[$this->currentPage - 1];
        return view('livewire.edit-project', ['currentPageData' => $currentPageData]);
    }

    public function setCurrentPage($page)
    {
        $this->currentPage = $page;
        $this->render();
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->render();
        }
    }
    
    public function nextPage()
    {
        if ($this->currentPage < ceil(count($this->dataImages) / $this->perPage)) {
            $this->currentPage++;
            $this->render();
        }
    }


    public function addSection($section)
    {
        $section = $section + 1;
        $this->section = $section;
        array_push($this->new_sections ,$section);
    }

      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeSection($section)
    {
        unset($this->new_sections[$section]);
        unset($this->name_section[$section]);
        unset($this->content_section[$section]);
    }
    
    public function addFinancial($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->financial_sections ,$i);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeFinancial($i)
    {
        unset($this->financial_sections[$i]);
        
        unset($this->finance_year[$i]);
        unset($this->finance_turnove[$i]);
        unset($this->finance_profit[$i]);
    }
    
    public function addMember($j)
    {
        $j = $j + 1;
        $this->j = $j;
        //set edit
        $is_edit = false;
        array_push($this->team_members ,$j);
    }


    // add video
    public function addVideo($section)
    {
        $section = $section + 1;
        $this->c_video = $section;
        array_push($this->list_videos ,$section);
    }

    public function removeVideo($section)
    {
        unset($this->list_videos[$section]);
    }
    
    public function addDocument($section)
    {
        $section = $section + 1;
        $this->c_document = $section;
        array_push($this->add_documents ,$section);
    }

    public function removeDocument($j)
    {
        //unset($this->add_documents[$section]);

        unset($this->add_document_name[$j]);
        unset($this->add_document_file[$j]);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeMember($j)
    {
        unset($this->team_members[$j]);

        unset($this->team_name[$j]);
        unset($this->linkedin[$j]);
        unset($this->position[$j]);
        unset($this->bio[$j]);
    }

    public function dealSubmit()
    { 
        $this->currentStep = 4;

        $add_investments = [];
        $this->add_investments_title = $this->add_investments_title ?? [];
        if(count($this->add_investments_title))
            foreach ($this->add_investments_title as $key => $value) {
                $obj = [];
                array_push($obj, $this->add_investments_title[$key] ?? NULL);
                array_push($obj, $this->add_investments_value[$key] ?? NULL);
                array_push($add_investments, $obj);
                
            } 
        
        //dd($add_investments);
    }
  

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function companySubmit()
    {

        $validatedData = $this->validate([
            'title' => 'required',
           
        ]);
 
        $this->currentStep = 2;
       //dd($this->located);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function pitchSubmit()
    {

        $validatedData = $this->validate([
            'short_summary' => 'required',
        ]);

        
        $custom_section = [];
        $this->name_section = $this->name_section ?? [];
        if(count($this->name_section))
            foreach ($this->name_section as $key => $value) {
                $obj = [];
                
                //$custom_section[$this->name_section[$key]] = $this->content_section[$key];
                array_push($obj, $this->name_section[$key] ?? NULL);
                array_push($obj, $this->content_section[$key] ?? NULL);

                array_push($custom_section, $obj);
                
            }
            
     
      
  
        $this->currentStep = 3;
    }
    public function teamSubmit()
    {

        $validatedData = $this->validate([
            'team_name.*' => 'required',
            ],
            [
                'team_name.*.required' => 'Team name field is required',
            ]
        );
  
        $this->currentStep = 5;
    }
    public function imageSubmit()
    {
  
        $validatedData = $this->validate([
            'short_summary' => 'required',
        ]);
  
        $this->currentStep = 6;
        
    }
    public function documentSubmit()
    {
  
        $validatedData = $this->validate([
            'short_summary' => 'required',
        ]);
  
        $this->currentStep = 7;
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForm()
    {
        
        
        // $this->validate([
        //     'images.*' => 'image|max:10240', // 10MB Max
        // ]);
        
        $list_img = [];
        
        if($this->images) {
            foreach ($this->images as $img) {
                $obj = $img;
                if(!is_string($img) && $img != NULL)
                    $obj = $img->store('ribano.org/users/' . Auth::id(), 's3');
                    // $this->photo->store('photos', 's3')
                array_push($list_img, $obj);
                
                
            }
            
                
        }
            
        if($this->existingImages) {
            foreach ($this->existingImages as $key => $value) {
                array_push($list_img, $value);
            }
        }
    
       
 
        
        $team_photo = [];
        
        $accept = $hights = [];
        if($this->accept_goods)
            array_push($accept, $this->accept_goods);
        if($this->fixed_assets)
            array_push($accept, $this->fixed_assets);
        if($this->accept_hires)
            array_push($accept, $this->accept_hires);
        // custom section
        $custom_section = [];
        $this->name_section = $this->name_section ?? [];
        if(count($this->name_section))
            foreach ($this->name_section as $key => $value) {
                $obj = [];
                
                array_push($obj, $this->name_section[$key] ?? NULL);
                array_push($obj, $this->content_section[$key] ?? NULL);
                array_push($custom_section, $obj);
                
            }
        
        $add_financials = [];
        $this->finance_year = $this->finance_year ?? [];
        if(count($this->finance_year))
            foreach ($this->finance_year as $key => $value) {
                $obj = [];
                array_push($obj, $this->finance_year[$key] ?? NULL);
                array_push($obj, $this->finance_turnove[$key] ?? NULL);
                array_push($obj, $this->finance_profit[$key] ?? NULL);
                
                
                array_push($add_financials, $obj);
                
            }
            
        // custom section here
        $list_videos = [];
        
        // if($this->video_item)
        //     foreach ($this->video_item as $key => $value) {
        //         array_push($list_videos, $this->video_item[$key] ?? NULL);
                
        //     }

        if($this->v_item) { 
       
            foreach ($this->v_item as $key => $value) {
                $obj = [];
                array_push($obj, $this->v_item[$key] ?? NULL);
                array_push($obj, $this->v_title[$key] ?? NULL);
                array_push($obj, $this->v_description[$key] ?? NULL);
                array_push($list_videos, $obj);

            }
        }
        
        // custom documents
        $documents =  [];
        if($this->add_document_name)
            foreach ($this->add_document_name as $key => $value) {
                $obj = [];
                //$file = $this->add_document_file[$key]->store('ribano.org/users/' . Auth::id(), 's3');
                $file = $this->add_document_file[$key] ?? NULL;
                if(!is_string($file) && $file != NULL)
                    $file = $this->add_document_file[$key]->store('ribano.org/users/' . Auth::id(), 's3');
                array_push($obj, $file);
                array_push($obj, $this->add_document_name[$key] ?? NULL);

                array_push($documents, $obj);
                
            }
            
        
        
        //team member
        $team_member = [];
       
        if($this->team_name)
            foreach ($this->team_name as $key => $value) {
                $obj = [];
                $file = $this->avatar[$key] ?? NULL;
                if(!is_string($file) && $file != NULL)
                    //$file = $this->avatar[$key]->store('files/users/' . Auth::id(), 'public');
                    $file = $this->avatar[$key]->store('ribano.org/users/' . Auth::id(), 's3');
                array_push($obj, $file);
                array_push($obj, $this->team_name[$key] ?? NULL);
                array_push($obj, $this->linkedin[$key] ?? NULL);
                array_push($obj, $this->position[$key] ?? NULL);
                array_push($obj, $this->bio[$key] ?? NULL);

                array_push($team_member, $obj);
                
            }
        
        // add_investments
        $add_investments = [];
        $this->add_investments_title = $this->add_investments_title ?? [];
        if(count($this->add_investments_title))
            foreach ($this->add_investments_title as $key => $value) {
                $obj = [];
                array_push($obj, $this->add_investments_title[$key] ?? NULL);
                array_push($obj, $this->add_investments_value[$key] ?? NULL);
                array_push($add_investments, $obj);
                
            } 
        
        
        // question and answer
        $add_questions = [];
        $this->question = $this->question ?? [];
        if(count($this->question))
            foreach ($this->question as $key => $value) {
                $obj = [];
                array_push($obj, $this->question[$key] ?? NULL);
                array_push($obj, $this->answer[$key] ?? NULL);
                array_push($add_questions, $obj);
                
            } 
        
            
        $project = Project::where('id', $this->project_id)->update([
            'title' => $this->title,
            'user_id' => Auth::id() ?? 0,
            'website' => $this->website,
            'located' => $this->located,
            'country' => $this->country,
            'mobile_number' => $this->mobile_number,
            'industry_1' => $this->industry_1,
            'industry_2' => $this->industry_2,
            'stage' => $this->stage,
            'ideal_investor_role' => $this->ideal_investor_role,
            'summary_title' => $this->summary_title,
            'short_summary' => $this->short_summary,
            'business_title' => $this->business_title,
            'the_business' => $this->the_business,
            'the_market' => $this->the_market,
            'progress_proof' => $this->progress_proof,
            'objectives_future' => $this->objectives_future,
            'custom_section' => $custom_section ? json_encode($custom_section) : NULL,
            'highlights' => $this->highlights ? implode('#%#', $this->highlights) : NULL,
            'equity_checked' => $this->equity_checked,
            'convertible_notes_checked' => $this->convertible_notes_checked,
            'raising' => $this->raising,
            'amount_of_investment' => $this->amount_of_investment,
            'investment_type' => $this->investment_type,
            'accept' => implode(',', $accept),
            'as_investments' => $this->as_investments,
            'investment_equity_grand' => $this->investment_equity_grand,
            'safe_target' => $this->safe_target,
            'investor_equity_numbers' => $this->investor_equity_numbers,
            'minimum_equity_investment' => $this->minimum_equity_investment,
            'maximum_equity_investment' => $this->maximum_equity_investment,
            'investment_equity_previous_rounds' => $this->investment_equity_previous_rounds,
            'total_share' => $this->total_share,
            'price_of_share' => $this->price_of_share,
            'shares_granted' => $this->shares_granted,
            'purchase_price' => $this->purchase_price,
            'date_of_issuance' => $this->date_of_issuance ? date('Y-m-d', strtotime($this->date_of_issuance)) : NULL,
            'exercise_price' => $this->exercise_price,
            'exercise_date' => $this->exercise_date ? date('Y-m-d', strtotime($this->exercise_date)) : NULL,
            'discount' => $this->discount,
            'maturity_date' => $this->maturity_date ? date('Y-m-d', strtotime($this->maturity_date)) :NULL,
            'valuation_cap' => $this->valuation_cap,
            'previous_round_raise' => $this->previous_round_raise,
            'have_you_raised' => $this->have_you_raised,
            'minimum_investment' => $this->minimum_investment,
            'maximum_investment' => $this->maximum_investment,
            'add_financials' => $add_financials ? json_encode($add_financials) : NULL,
            'add_more_investment' => $add_investments ? json_encode($add_investments) : NULL,
            'tags' => $this->tags ? implode('%###%', $this->tags) : NULL,
            'team_overview' => $this->team_overview,
            'team_members' => $team_member ? json_encode($team_member) : NULL,
            'logo' => (!is_string($this->logo) && $this->logo != NULL) ?  $this->logo->store('ribano.org/users/' . Auth::id(), 's3') : $this->logo,
            'banner' => (!is_string($this->banner) && $this->banner != NULL) ? $this->banner->store('ribano.org/users/' . Auth::id(), 's3') : $this->banner,
            'images' => $list_img ? implode('%###%', $list_img) : NULL,
            'video_url' => $this->video_url ?? NULL,
            'video_title' => $this->video_title ?? NULL,
            'video_description' => $this->video_description ?? NULL,
            'add_video' => $list_videos ? json_encode($list_videos) : NULL,
            'business_plan' => (!is_string($this->business_plan) && $this->business_plan != NULL) ? $this->business_plan->store('ribano.org/users/' . Auth::id(), 's3') : $this->business_plan,
            'financials' => (!is_string($this->financials) && $this->financials != NULL) ? $this->financials->store('ribano.org/users/' . Auth::id(), 's3') : $this->financials,
            'pitch_deck' => (!is_string($this->pitch_deck) && $this->pitch_deck != NULL) ? $this->pitch_deck->store('ribano.org/users/' . Auth::id(), 's3') : $this->pitch_deck,
            'executive_summary' => (!is_string($this->executive_summary) && $this->executive_summary != NULL) ? $this->executive_summary->store('ribano.org/users/' . Auth::id(), 's3') : $this->executive_summary,
            'additional_documents' => (!is_string($this->additional_documents) && $this->additional_documents != NULL) ? $this->additional_documents->store('ribano.org/users/' . Auth::id(), 's3') : $this->additional_documents,
            'additional_documents_name' => $this->additional_documents_name,
            'question_answer' => $add_questions ? json_encode($add_questions) : NULL,

            'more_documents' => $documents ? json_encode($documents) : NULL,
            //'status' => 1,
            // 'token_name' => $this->token_name,
            // 'token_symbol' => $this->token_symbol,
            // 'total_supply' => $this->total_supply,
            // 'token_decimals' => $this->token_decimals,
            // 'token_icon' => ($this->token_icon),
            
        ]);
        
        // Check new title update
        $slug = $this->slug;
        // update slug
        if(Str::slug($this->title) . '-' . $this->project_id != $this->slug) {
            Project::where('id', $this->project_id)->update([
                'slug' => Str::slug($this->title) . '-' . $this->project_id
            ]);
            $slug = Str::slug($this->title) . '-' . $this->project_id;
        }
           
  
        $this->clearForm();

        //$this->successMessage = 'Project edit successfully.';
  
        $this->currentStep = 1;
        session()->flash('message', 'Project edit successfully.');
        //redirect()->route('user.editProject', $slug);
        return back();
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function back($step)
    {
        $this->currentStep = $step;    
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
