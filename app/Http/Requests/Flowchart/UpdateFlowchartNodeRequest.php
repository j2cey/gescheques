<?php

namespace App\Http\Requests\Flowchart;



use App\Models\WorkflowStep;

/**
 * @property WorkflowStep $workflowstep
 */
class UpdateFlowchartNodeRequest extends FlowchartRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return WorkflowStep::updateFlowchartNodeRules($this->workflowstep);
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'flowchart_position_x' => intval($this->input('flowchart_position_x')),
            'flowchart_position_y' => intval($this->input('flowchart_position_y')),
            'flowchart_size_width' => intval($this->input('flowchart_size_width')),
            'flowchart_size_height' => intval($this->input('flowchart_size_height')),
        ]);
    }
}
