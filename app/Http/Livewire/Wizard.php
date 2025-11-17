<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Product;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class Wizard extends Component
{
    use WithFileUploads;
    public $currentStep = 1;
    public $title, $website = "https://", $located, $phone_code, $country, $mobile_number, $short_summary, $tags = [];
    public $industry_1, $industry_2, $stage, $ideal_investor_role, $the_business, $the_market, $progress_proof;
    public $objectives_future, $custom_section;
    public $section = 1, $i = 1, $j = 1, $c_investment = 1, $c_question = 1, $name_section, $content_section, $finance_year, $finance_turnove, $finance_profit;
    public $new_sections = [], $highlights = [], $amount, $equity_checked, $convertible_notes_checked, $raising, $amount_of_investment;
    public $investment_type, $as_investments, $accept_goods, $fixed_assets, $accept_hires, $purchase_price;
    public $date_of_issuance, $exercise_price, $exercise_date, $discount, $maturity_date, $valuation_cap;
    public $previous_round_raise, $have_you_raised, $minimum_investment, $maximum_investment, $financial_sections = [];
    public $show_equity = false, $show_convertible =  false;
    public $team_overview, $avatar, $team_name, $linkedin, $position, $bio, $team_members = [];
    public $logo, $banner, $images = [], $video_url, $business_plan, $financials, $pitch_deck;
    public $executive_summary, $additional_documents, $term, $question_answers = [], $question, $answer;
    public $successMessage = '', $taskduedate, $tag_test, $tagInput, $add_investments = [], $add_investments_title, $add_investments_value;
    public $token_name = '', $token_symbol , $total_supply = 1000000000, $token_decimals = 18, $owner_account_id, $token_icon, $icon, $img_icon;
    public $total_share, $price_of_share, $shares_granted, $total_investment = 0;
    public $summary_title, $business_title, $additional_documents_name, $the_market_title, $progress_proof_title, $objectives_future_title;

    public $errorMessage, $c_video = 1, $list_videos = [], $c_document = 1, $video_item, $add_documents = [], $add_document_name, $add_document_file;
    public $video_title, $video_description, $investment_grand, $investor_numbers, $v_title, $v_description, $v_item, $safe_target;

    public $investment_equity_grand, $investor_equity_numbers, $minimum_equity_investment, $maximum_equity_investment, $investment_equity_previous_rounds;
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function render()
    {
        return view('livewire.wizard');
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
        $this->purchase_price = n_format($this->purchase_price);
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


    public function updatedphoneCode($value)
    {
       $this->mobile_number = $value;
    }
    public function updatedhighlights($value)
    {
        //dd($this->highlights);
        //   var_dump($this->name_section);
        //   dd($this->content_section);
    }


    public function deleteTempImage($index)
    {
        if ($index < count($this->images)) {
            $newImageIndex = $index ;
            unset($this->images[$newImageIndex]);
            $this->images = array_values($this->images);
        }
    }

    public function updatedIcon()
    {
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

    public function removeDocument($section)
    {
        unset($this->add_documents[$section]);
    }

    public function addSection($section)
    {
        $section = $section + 1;
        $this->section = $section;
        array_push($this->new_sections ,$section);

        $this->dispatchBrowserEvent('initSummernote', ['id' => 'content_section' . $section]);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeSection($section)
    {
        unset($this->new_sections[$section]);
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
    }


    public function addInvestment($i)
    {
        $i = $i + 1;
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
        foreach ($this->add_investments_value as $key => $value) {
            // if (is_numeric($value)) {
                 $this->add_investments_value[$key] = n_format($value);
            // }
        }
        $this->updateTotal();
    }

    public function updatedAsInvestments()
    {

        // if (is_numeric($this->as_investments) && empty($this->add_investments_value))
        //     $this->total_investment = floatval($this->as_investments);
        // else {
        //     $this->total_investment = 0;
        //     foreach ($this->add_investments_value as $value) {
        //         if (is_numeric($value)) {
        //             $this->total_investment += floatval($value);
        //         }
        //     }
        // }
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
        //$this->total_investment = floatval($this->total_investment) + floatval($this->as_investments);

    }

    private function updateTotal()
    {
        // $this->total_investment = 0;

        // foreach ($this->add_investments_value as $value) {
        //     if (is_numeric($value)) {
        //         $this->total_investment += floatval($value);
        //     }
        // }

        // if(is_numeric($this->as_investments))
        //     $this->total_investment = floatval($this->total_investment) + floatval($this->as_investments);
        $this->total_investment = 0;
        $this->add_investments_value = $this->add_investments_value ?? [];

        foreach ($this->add_investments_value as $value) {
            if ((is_numeric(unformatNumber($value)))) {
                $this->total_investment += floatval(unformatNumber($value));
            }
        }

        if(is_numeric(unformatNumber($this->as_investments)))
            $this->total_investment = floatval(unformatNumber($this->total_investment)) + floatval(unformatNumber($this->as_investments));


    }

    public function addMember($j)
    {
        $j = $j + 1;
        $this->j = $j;
        array_push($this->team_members ,$j);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeMember($j)
    {
        unset($this->team_members[$j]);
    }


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function companySubmit()
    {



        try {
            // dd('test');
            $this->errorMessage  = '';
            $this->successMessage = '';
            $validatedData = $this->validate([
                'title' => 'required',
            ]);

            // dd($validatedData);

            $this->currentStep = 2;
        } catch (\Exception $e) {
            $errors = $e->validator->errors();
            $rules = $errors->getMessages();
            $customErrors = [];

            foreach ($errors->all() as $error) {
                $customErrors[] = $error;
            }

            $this->dispatchBrowserEvent('scrollToError', ['customErrors' => $customErrors]);



            $this->errorMessage = $customErrors;
        }
    }

    public function dealSubmit()
    {
        $this->currentStep = 4;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function pitchSubmit()
    {
        try {
            $this->errorMessage  = '';
            $validatedData = $this->validate([
                'short_summary' => 'required',
            ]);


            $this->currentStep = 3;
        } catch (\Exception $e) {
            $errors = $e->validator->errors();
            $rules = $errors->getMessages();
            $customErrors = [];

            foreach ($errors->all() as $error) {
                $customErrors[] = $error;
            }


            $this->dispatchBrowserEvent('scrollToError', ['customErrors' => $customErrors]);

            $this->errorMessage = $customErrors;
           // $this->dispatchBrowserEvent('scrollToErrorDiv');
        }


    }


    public function teamSubmit()
    {

        try {
            $this->errorMessage  = '';
            $validatedData = $this->validate([
                'team_name.*' => 'required',
                ],
                [
                    'team_name.*.required' => 'Team name field is required gge' ,
                ]
            );

            $this->currentStep = 5;
        } catch (\Exception $e) {
            $errors = $e->validator->errors();
            $rules = $errors->getMessages();
            $customErrors = [];



            foreach ($errors->all() as $error) {
                $customErrors[] = $error;
            }


           // $this->dispatchBrowserEvent('scrollToError', ['customErrors' => $customErrors]);
            $this->errorMessage = $customErrors;
        }


    }
    public function imageSubmit()
    {

        $this->errorMessage  = '';
        $this->currentStep = 6;
    }
    public function documentSubmit()
    {



        $this->currentStep = 7;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForm()
    {
        $this->errorMessage  = '';

        $this->validate([
            'images.*' => 'image|max:50240', // 10MB Max
            // 'token_name' => 'required|string|max:255',
            // 'token_symbol' => 'required|string|max:50|unique:projects,token_symbol,',
            // 'total_supply' => 'required',
            // 'token_decimals' => 'required',
            // 'token_icon' => 'required',

        ]);

        $list_img = [];

        if($this->images)
            foreach ($this->images as $img) {
                $obj = $img->store('ribano.org/users/' . Auth::id(), 's3');
                array_push($list_img, $obj);
            }

        //dd(implode(',', $list_img));

        $team_photo = [];
        // foreach ($this->photos as $photo) {
        //     $photo->store('photos');
        // }

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

                //$custom_section[$this->name_section[$key]] = $this->content_section[$key];
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

        // Question and answer
        $add_questions = [];
        $this->question = $this->question ?? [];
        if(count($this->question))
            foreach ($this->question as $key => $value) {
                $obj = [];
                array_push($obj, $this->question[$key] ?? NULL);
                array_push($obj, $this->answer[$key] ?? NULL);
                array_push($add_questions, $obj);

            }
        // custom field here

        $list_videos = [];

        if($this->video_item)
            foreach ($this->video_item as $key => $value) {
                $obj = [];

                array_push($obj, $this->video_item[$key] ?? NULL);
                array_push($obj, $this->v_title[$key] ?? NULL);
                array_push($obj, $this->v_description[$key] ?? NULL);
                array_push($list_videos, $obj);

            }

        // custom documents
        $documents =  [];
        if($this->add_document_name)
            foreach ($this->add_document_name as $key => $value) {
                $obj = [];
                if(array_key_exists($key, $this->add_document_file)) {
                    $file = $this->add_document_file[$key]->store('ribano.org/users/' . Auth::id(), 's3');
                    array_push($obj, $file);
                }

                array_push($obj, $this->add_document_name[$key] ?? NULL);

                array_push($documents, $obj);

            }


        //team member
        $team_member = [];

        if($this->team_name)
            foreach ($this->team_name as $key => $value) {
                $obj = [];
                $file = $this->avatar[$key]->store('ribano.org/users/' . Auth::id(), 's3');
                array_push($obj, $file ?? NULL);
                array_push($obj, $this->team_name[$key] ?? NULL);
                array_push($obj, $this->linkedin[$key] ?? NULL);
                array_push($obj, $this->position[$key] ?? NULL);
                array_push($obj, $this->bio[$key] ?? NULL);

                array_push($team_member, $obj);

            }


        $project = Project::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
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
            'the_market_title' => $this->the_market_title,
            'the_market' => $this->the_market,
            'progress_proof_title' => $this->progress_proof_title,
            'progress_proof' => $this->progress_proof,
            'objectives_future_title' => $this->objectives_future_title,
            'objectives_future' => $this->objectives_future,
            'custom_section' => $custom_section ? json_encode($custom_section) : NULL,
            'highlights' => $this->highlights ? implode('#%#', $this->highlights) : NULL,
            'equity_checked' => $this->equity_checked,
            'convertible_notes_checked' => $this->convertible_notes_checked,
            'investment_grand' => $this->investment_grand,
            'investor_numbers' => $this->investor_numbers,

            'safe_target' => $this->safe_target,
            'investment_equity_grand' => $this->investment_equity_grand,
            'investor_equity_numbers' => $this->investor_equity_numbers,
            'minimum_equity_investment' => $this->minimum_equity_investment,
            'maximum_equity_investment' => $this->maximum_equity_investment,
            'investment_equity_previous_rounds' => $this->investment_equity_previous_rounds,


            'raising' => $this->raising,
            'amount_of_investment' => $this->amount_of_investment,
            'investment_type' => $this->investment_type,
            'accept' => implode(',', $accept),
            'as_investments' => $this->as_investments,
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

            'logo' => $this->logo ? $this->logo->store('ribano.org/users/' . Auth::id(), 's3') : NULL,
            'banner' => $this->banner ? $this->banner->store('ribano.org/users/' . Auth::id(), 's3') : NULL,
            'images' => $list_img ? implode('%###%', $list_img) : NULL,
            'video_url' => $this->video_url ?? NULL,
            'video_title' => $this->video_title ?? NULL,
            'video_description' => $this->video_description ?? NULL,
            'add_video' => $list_videos ? json_encode($list_videos) : NULL,
            'business_plan' => $this->business_plan ? $this->business_plan->store('ribano.org/users/' . Auth::id(), 's3') : NULL,
            'financials' => $this->financials ? $this->financials->store('ribano.org/users/' . Auth::id(), 's3') : NULL,
            'pitch_deck' => $this->pitch_deck ? $this->pitch_deck->store('ribano.org/users/' . Auth::id(), 's3') : NULL,
            'executive_summary' => $this->executive_summary ? $this->executive_summary->store('ribano.org/users/' . Auth::id(), 's3') : NULL,

            'additional_documents_name' => $this->additional_documents_name,
            'additional_documents' => $this->additional_documents ? $this->additional_documents->store('ribano.org/users/' . Auth::id(), 's3') : NULL,
            //'term' => $this->additional_documents,
            'more_documents' => $documents ? json_encode($documents) : NULL,
            'question_answer' => $add_questions ? json_encode($add_questions) : NULL,
            'status' => 0,

        ]);
        // update
        if($project)
            Project::where('id', $project->id)->update([
                'slug' => Str::slug($this->title) . '-' . $project->id
            ]);

        $this->clearForm();

        $this->successMessage = 'Project Created Successfully.';

        $this->currentStep = 1;
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
        $this->reset();
        // $this->title = '';
        // $this->short_summary = '';
    }
}
