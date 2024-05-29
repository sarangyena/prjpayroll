<form method="POST" action="{{ isset($employee) ? route('a-updateEmp', $employee) : route('a-addEmp') }}" id="empForm"
    enctype="multipart/form-data">
    @csrf
    @if (isset($employee))
        @method('patch')
        @php
            $name = str_replace(',', '', $employee->name);
            $emp = explode(' ', $name);
        @endphp
    @endif
    <div class="columns-2 py-2">
        <img src="{{ asset('images/user.png') }}" class="w-52 h-max mx-auto" id="imagePreview">
        <x-input-label for="imagePreview" :value="__('Upload Employee Image:')" />
        <x-text-input id="image" class="block mt-1 w-full uppercase" type="file" name="image"
            accept="image/*" />
        <div class="mt-2">
            <x-input-label for="user_name" :value="__('User ID:')" />
            <x-text-input id="user_name" class="block mt-1 w-full uppercase" type="text" name="user_name" readonly
                value="{{ isset($employee) ? $employee->user_name : null }}" />
        </div>
        @if (isset($employee) && $employee->role == 'ON-CALL')
            <div class="mt-3 flex items-center mb-4">
                <input id="promote" type="checkbox" value="true" name="promote"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="promote" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Promote
                    to regular employee</label>
            </div>
        @elseif (!isset($employee))
            <div class="flex gap-5 py-5">
                <x-input-label for="imagePreview" :value="__('Role:')" />
                <input type="radio" id="emp" name="role" value="EMPLOYEE"
                    @if (isset($employee) && $employee->role == 'EMPLOYEE') checked @endif>
                <x-input-label for="emp" :value="__('EMPLOYEE')" />
                <input type="radio" id="on" name="role" value="ON-CALL"
                    @if (isset($employee) && $employee->role == 'ON-CALL') checked @endif>
                <x-input-label for="on" :value="__('ON-CALL')" />
            </div>
        @endif


    </div>
    <div class="mt-2 columns-3">
        <x-input-label for="last_name" :value="__('Last Name:')" />
        <x-text-input id="last_name" class="block mt-1 w-full uppercase" type="text" name="last_name"
            value="{{ isset($employee) ? $employee->last_name : null }}" />
        <x-input-label for="first_name" :value="__('First Name:')" />
        <x-text-input id="first_name" class="block mt-1 w-full uppercase" type="text" name="first_name"
            value="{{ isset($employee) ? $employee->first_name : null }}" />
        <x-input-label for="middle_name" :value="__('Middle Name:')" />
        <x-text-input id="middle_name" class="block mt-1 w-full uppercase" type="text" name="middle_name"
            value="{{ isset($employee) ? $employee->middle_name : null }}" />
    </div>
    <div class="mt-2 columns-3">
        <x-input-label for="status" :value="__('Status:')" />
        <x-select-input id="status" name="status" class="mt-1">
            <option selected value="{{ isset($employee) ? $employee->status : null }}" disabled>
                {{ isset($employee) ? $employee->status : '----------' }}</option>
            <option value="SINGLE">SINGLE</option>
            <option value="MARRIED">MARRIED</option>
            <option value="DIVORCED">DIVORCED</option>
        </x-select-input>
        <x-input-label for="email" :value="__('Email:')" />
        <x-text-input id="email" class="block mt-1 w-full uppercase" type="email" name="email"
            value="{{ isset($employee) ? $employee->email : null }}" />
        <x-input-label for="phone" :value="__('Phone No.:')" />
        <x-text-input id="phone" class="block mt-1 w-full uppercase" type="text" name="phone"
            value="{{ isset($employee) ? $employee->phone : null }}" />
    </div>
    <div class="mt-2 columns-3">
        <x-input-label for="job" :value="__('Job:')" />
        <x-select-input id="job" name="job" class="mt-1">
            <option selected disabled value="{{ isset($employee) ? $employee->job : null }}">
                {{ isset($employee) ? $employee->job : '----------' }}</option>
            <option value="AREA MANAGER">AREA MANAGER</option>
            <option value="BOOK KEEPER">BOOK KEEPER</option>
            <option value="CASHIER">CASHIER</option>
            <option value="COLLECTOR">COLLECTOR</option>
            <option value="FARMERS">FARMERS</option>
            <option value="FARM MANAGER">FARM MANAGER</option>
            <option value="GENERAL MANAGER">GENERAL MANAGER</option>
            <option value="HR">HR</option>
            <option value="PAYROLL ASSISTANT">PAYROLL ASSISTANT</option>
            <option value="SECRETARY">SECRETARY</option>
            <option value="SUPERVISOR">SUPERVISOR</option>
            <option value="TECH SUPPORT">TECH SUPPORT</option>
        </x-select-input>
        <x-input-label for="sss" :value="__('SSS No.:')" />
        <x-text-input id="sss" class="block mt-1 w-full uppercase" type="text" name="sss"
            value="{{ isset($employee) ? $employee->sss : null }}" />
        <x-input-label for="philhealth" :value="__('PhilHealth No.:')" />
        <x-text-input id="philhealth" class="block mt-1 w-full uppercase" type="text" name="philhealth"
            value="{{ isset($employee) ? $employee->philhealth : null }}" />
    </div>
    @if (!isset($employee))
        <x-input-label for="rate" :value="__('Rate:')" class="mt-2" />
        <x-text-input id="rate" class="block mt-1 w-full uppercase" type="text" name="rate"
            value="{{ isset($employee) ? $employee->rate : null }}" value="430" />
    @endif
    <p class="font-semibold text-2xl leading-5 border-b-2 pb-2 mt-3 border-green-300">ADDRESS:</p>
    <x-input-label for="address" :value="__('Address:')" />
    <x-text-input id="address" class="block mt-1 w-full uppercase" type="text" name="address"
        value="{{ isset($employee) ? $employee->address : null }}" />
    <p class="font-semibold text-2xl leading-5 border-b-2 pb-2 mt-2 border-green-300">EMERGENCY
        CONTACT:</p>
    <x-input-label for="eName" :value="__('Full Name:')" />
    <x-text-input id="eName" class="block mt-1 w-full uppercase" type="text" name="eName"
        value="{{ isset($employee) ? $employee->eName : null }}" />
    <x-input-label for="ePhone" :value="__('Phone No.:')" />
    <x-text-input id="ePhone" class="block mt-1 w-full uppercase" type="text" name="ePhone"
        value="{{ isset($employee) ? $employee->ePhone : null }}" />
    <x-input-label for="eAdd" :value="__('Address:')" />
    <x-text-input id="eAdd" class="block mt-1 w-full uppercase" type="text" name="eAdd"
        value="{{ isset($employee) ? $employee->eAdd : null }}" />
    <div class="flex mt-2 flex-row-reverse">
        <x-primary-button class="m-3">
            {{ isset($employee) ? __('Save') : __('Add') }}
        </x-primary-button>
        @if (!isset($employee))
            <x-secondary-button id="clear" class="m-3">
                {{ __('Clear') }}
            </x-secondary-button>
        @endif
    </div>
</form>
