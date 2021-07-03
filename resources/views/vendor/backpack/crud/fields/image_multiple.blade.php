{{-- REPEATABLE FIELD TYPE --}}

@php
  $field['value'] = old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ));
  // make sure the value is a JSON string (not array, if it's cast in the model)
  $field['value'] = is_array($field['value']) ? json_encode($field['value']) : $field['value'];

  $field['init_rows'] = $field['init_rows'] ?? $field['min_rows'] ?? 1;
  $field['max_rows'] = $field['max_rows'] ?? 0;
  $field['min_rows'] =  $field['min_rows'] ?? 0;
@endphp

@include('crud::fields.inc.wrapper_start')
  <label>{!! $field['label'] !!}</label>
  @include('crud::fields.inc.translatable_icon')
  <input
      type="hidden"
      name="{{ $field['name'] }}"
      data-init-function="bpFieldInitRepeatableElement"
      value="{{ $field['value'] }}"
      @include('crud::fields.inc.attributes')
  >

  {{-- HINT --}}
  @if (isset($field['hint']))
      <p class="help-block text-muted text-sm">{!! $field['hint'] !!}</p>
  @endif



<div class="container-repeatable-elements">
    <div
        data-repeatable-holder="{{ $field['name'] }}"
        data-init-rows="{{ $field['init_rows'] }}"
        data-max-rows="{{ $field['max_rows'] }}"
        data-min-rows="{{ $field['min_rows'] }}"
        data-invisible-rows="0"
    ></div>

    @push('before_scripts')
    <div class="col-md-12 well repeatable-element row m-1 p-2" data-repeatable-identifier="{{ $field['name'] }}">
        <button type="button" class="close delete-element"><span aria-hidden="true">×</span></button>
        <input class="image-id-holder" type="hidden" value="0">
        @php
            $imageField = $crud->makeSureFieldHasNecessaryAttributes([
                'label' => "",
                'name' => "image",
                'type' => 'image',
                'crop' => true,
                'aspect_ratio' => 1,
                'prefix'    => 'uploads/images/bikes/',
                'wrapper' => [
                    'class' => 'form-group col-sm-12 image-holder'
                ],
            ]);
            $fieldViewNamespace = $imageField['view_namespace'] ?? 'crud::fields';
            $fieldViewPath = $fieldViewNamespace.'.'.$imageField['type'];
            $imageField['showAsterisk'] = false;
        @endphp

        @include($fieldViewPath, ['field' => $imageField])

        @php
            $isFeaturedField = $crud->makeSureFieldHasNecessaryAttributes([
                'name' => 'is_featured',
                'label' => 'Feature Image?',
                'type' => 'checkbox',
                'wrapper' => [
                    'class' => 'form-group col-sm-12 is-featured-holder'
                ],
            ]);
            $fieldViewNamespace = $isFeaturedField['view_namespace'] ?? 'crud::fields';
            $fieldViewPath = $fieldViewNamespace.'.'.$isFeaturedField['type'];
            $isFeaturedField['showAsterisk'] = false;
        @endphp

        @include($fieldViewPath, ['field' => $isFeaturedField])

    </div>
    @endpush

  </div>


  <button type="button" class="btn btn-outline-primary btn-sm ml-1 add-repeatable-element-button">+ {{ $field['new_item_label'] ?? trans('backpack::crud.new_item') }}</button>

@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
  @php
      $crud->markFieldTypeAsLoaded($field);
  @endphp
  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

  @push('crud_fields_styles')
      <style type="text/css">
        .repeatable-element {
          border: 1px solid rgba(0,40,100,.12);
          border-radius: 5px;
          background-color: #f0f3f94f;
        }
        .container-repeatable-elements .delete-element {
          z-index: 2;
          position: absolute !important;
          margin-left: -24px;
          margin-top: 0px;
          height: 30px;
          width: 30px;
          border-radius: 15px;
          text-align: center;
          background-color: #e8ebf0 !important;
        }
      </style>
  @endpush

  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

  @push('crud_fields_scripts')
      <script>
        function bpFieldInitRepeatableElement(element) {

            var field_name = element.attr('name');

            var container = $('[data-repeatable-identifier='+field_name+']');
            var container_holder = $('[data-repeatable-holder='+field_name+']');

            var init_rows = Number(container_holder.attr('data-init-rows'));
            var min_rows = Number(container_holder.attr('data-min-rows'));
            var max_rows = Number(container_holder.attr('data-max-rows')) || Infinity;

            var field_group_clone = container.clone();
            container.remove();

            element.parent().find('.add-repeatable-element-button').click(function(){
                newRepeatableElement(container, field_group_clone);
            });

            if (element.val()) {
                var repeatable_fields_values = JSON.parse(element.val());

                for (var i = 0; i < repeatable_fields_values.length; ++i) {
                    newRepeatableElement(container, field_group_clone, repeatable_fields_values[i]);
                }
            } else {
                var container_rows = 0;
                var add_entry_button = element.parent().find('.add-repeatable-element-button');
                for(let i = 0; i < Math.min(init_rows, max_rows || init_rows); i++) {
                    container_rows++;
                    add_entry_button.trigger('click');
                }
            }
        }

        function newRepeatableElement(container, field_group, values) {

            var field_name = container.data('repeatable-identifier');
            var new_field_group = field_group.clone();

            var container_holder = $('[data-repeatable-holder='+field_name+']');

            var imageIdInput = new_field_group.find(".image-id-holder")[0];
            var imageInput = new_field_group.find(".image-holder input[type='hidden']")[0];
            var isFeaturedInput = new_field_group.find(".is-featured-holder input")[0];

            new_field_group.find('.delete-element').click(function(){
                if (values != null && values.id != 0) {
                    new_field_group.find(".image-holder input[type='hidden']").val('');
                    $(this).parent().addClass('d-none');
                    var currentInvisibleRows = Number(container_holder.attr('data-invisible-rows'));
                    container_holder.attr('data-invisible-rows', currentInvisibleRows + 1);
                } else {
                    new_field_group.find('input').each(function(i, el) {
                        $(el).trigger('backpack_field.deleted');
                    });
                    updateRepeatableRowCount(container_holder, -1);
                    $(this).parent().remove();
                }
                setupElementRowsNumbers(container_holder);
            });

            if (values != null) {
                new_field_group.find(".image-id-holder").val(values.id);
                new_field_group.find(".image-holder input[type='hidden']").val(values.file);
                new_field_group.find(".is-featured-holder input").val(values.is_featured);
            }
            
            container_holder.append(new_field_group);
            setupElementRowsNumbers(container_holder);
            updateRepeatableRowCount(container_holder, 1);
            initializeFieldsWithJavascript(container_holder);
        }

        function setupElementRowsNumbers(container) {
            container.children().each(function(i, el) {
                var rowNumber = i+1;
                $(el).attr('data-row-number', rowNumber);
                //also attach the row number to all the input elements inside
                $(el).find('input, select, textarea').each(function(i, el) {
                    $(el).attr('data-row-number', rowNumber);
                });
                var imageIdInput = el.querySelector(".image-id-holder");
                var imageInput = el.querySelector(".image-holder input[type='hidden']");
                var isFeaturedInput = el.querySelector(".is-featured-holder input");
                imageIdInput.name = @json($field['name']) + '[' + i + '][id]';
                imageInput.name = @json($field['name']) + '[' + i + '][image]';
                isFeaturedInput.name = @json($field['name']) + '[' + i + '][is_featured]';
            });
        }

        function updateRepeatableRowCount(container, amount) {
            let max_rows = Number(container.attr('data-max-rows')) + container.attr('data-invisible-rows') || Infinity;
            let min_rows = Number(container.attr('data-min-rows')) - container.attr('data-invisible-rows') || 0;

            let current_rows = Number(container.attr('number-of-rows')) || 0;
            current_rows += amount;

            container.attr('number-of-rows', current_rows);

            // show or hide delete button
            container.find('.delete-element').toggleClass('d-none', current_rows <= min_rows);

            // show or hide new item button
            container.parent().parent().find('.add-repeatable-element-button').toggleClass('d-none', current_rows >= max_rows);
        }
    </script>
  @endpush
@endif
