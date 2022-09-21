<div class="flex" x-data="{valueId: {{$valueId}}}">
    <select
        x-ref="select"
        name="{$modelName}_{$rowId}"
        class="w-full m-1 text-sm leading-4 block rounded-md border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
        wire:input="saveData({{$rowId}}, '{{$modelName}}' , $event.target.value)"
        x-model="valueId"
    >
        @if($nullable)
            <option value=""></option>
        @endif
        @foreach ($options as $option)
            <option data-id="{{$valueId}}" value="{{$option->id}}">{{$option->area->title}}</option>
        @endforeach
    </select>
</div>
