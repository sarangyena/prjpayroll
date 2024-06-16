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
    <div class="mt-3 lg:columns-2">
        <img src="{{ asset('images/user.png') }}" class="w-1/2 mx-auto lg:w-48" id="imagePreview">
        <x-input-label for="imagePreview" :value="__('Upload Image:')" class=mt-3 />
        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
        <div class="mt-3">
            <x-input-label for="user_name" :value="__('User ID:')" />
            <x-text-input id="user_name" class="block mt-1 uppercase w-full" type="text" name="user_name" readonly
                value="{{ isset($employee) ? $employee->user_name : old('user_name') }}" />
        </div>
        @if (isset($employee) && $employee->role == 'ON-CALL')
            <div class="mt-3 flex items-center mb-4">
                <input id="promote" type="checkbox" value="true" name="promote"
                    @if (old('promote') == 'true') checked @endif
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="promote" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Promote
                    to regular employee</label>
            </div>
        @elseif (!isset($employee))
            <div class="flex justify-evenly mt-3 lg:mt-10">
                <x-input-label for="imagePreview" :value="__('Role:')" />
                <input type="radio" id="emp" name="role" value="EMPLOYEE"
                    @if ((isset($employee) && $employee->role == 'EMPLOYEE') || old('role') == 'EMPLOYEE') checked @endif>
                <x-input-label for="emp" :value="__('EMPLOYEE')" />
                <input type="radio" id="on" name="role" value="ON-CALL"
                    @if ((isset($employee) && $employee->role == 'ON-CALL') || old('role') == 'ON-CALL') checked @endif>
                <x-input-label for="on" :value="__('ON-CALL')" />
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        @endif
    </div>
    <div class="mt-3 lg:columns-3">
        <x-input-label for="last_name" :value="__('Last Name:')" />
        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" required
            value="{{ isset($employee) ? $employee->last_name : old('last_name') }}" />
        @error('last_name')
            <x-error>{{ $message }}</x-error>
        @enderror

        <x-input-label for="first_name" :value="__('First Name:')" class="mt-2" />
        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
            value="{{ isset($employee) ? $employee->first_name : old('first_name') }}" />
        @error('first_name')
            <x-error>{{ $message }}</x-error>
        @enderror

        <x-input-label for="middle_name" :value="__('Middle Name:')" class="mt-2" />
        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name"
            value="{{ isset($employee) ? $employee->middle_name : old('middle_name') }}" />
        @error('middle_name')
            <x-error>{{ $message }}</x-error>
        @enderror

    </div>
    <div class="lg:columns-3">
        <x-input-label for="status" :value="__('Status:')" class="mt-2 lg:mt-0" />
        <x-select-input id="status" name="status" class="block w-full mt-1">
            <option value="{{ isset($employee) ? $employee->status : old('status') }}">
                {{ isset($employee) ? $employee->status : old('status') }}</option>
            <option value="SINGLE">SINGLE</option>
            <option value="MARRIED">MARRIED</option>
            <option value="DIVORCED">DIVORCED</option>
        </x-select-input>
        @error('status')
            <x-error>{{ $message }}</x-error>
        @enderror

        <x-input-label for="email" :value="__('Email:')" class="mt-2" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
            value="{{ isset($employee) ? $employee->email : old('email') }}" />
        @error('email')
            <x-error>{{ $message }}</x-error>
        @enderror

        <x-input-label for="phone" :value="__('Phone No.:')" class="mt-2" />
        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
            value="{{ isset($employee) ? $employee->phone : old('phone') }}" />
        @error('phone')
            <x-error>{{ $message }}</x-error>
        @enderror

    </div>
    <div class="lg:columns-3">
        <x-input-label for="job" :value="__('Job:')" class="mt-2 lg:mt-0" />
        <x-select-input id="job" name="job" class="block w-full mt-1">
            <option value="{{ isset($employee) ? $employee->job : old('job') }}">
                {{ isset($employee) ? $employee->job : old('job') }}</option>
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
        @error('job')
            <x-error>{{ $message }}</x-error>
        @enderror

        <x-input-label for="sss" :value="__('SSS No.:')" class="mt-2" />
        <x-text-input id="sss" class="block mt-1 w-full" type="text" name="sss"
            value="{{ isset($employee) ? $employee->sss : old('sss') }}" />
        @error('sss')
            <x-error>{{ $message }}</x-error>
        @enderror

        <x-input-label for="philhealth" :value="__('PhilHealth No.:')" class="mt-2" />
        <x-text-input id="philhealth" class="block mt-1 w-full" type="text" name="philhealth"
            value="{{ isset($employee) ? $employee->philhealth : old('philhealth') }}" />
        @error('philhealth')
            <x-error>{{ $message }}</x-error>
        @enderror

    </div>
    <x-input-label for="rate" :value="__('Rate:')" class="mt-2" />
    <x-text-input id="rate" class="block mt-1 w-full" type="text" name="rate"
        value="{{ isset($employee) ? $employee->rate : 430}}" />
    @error('rate')
        <x-error>{{ $message }}</x-error>
    @enderror
    <div class="mt-2">
        <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">ADDRESS</p>
        <x-input-label for="address" :value="__('Address:')" class="mt-2" />
        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
            value="{{ isset($employee) ? $employee->address : old('address') }}" />
        @error('address')
            <x-error>{{ $message }}</x-error>
        @enderror

    </div>

    <div class="mt-3">
        <p class="font-bold text-lg border-b-2 border-green-300 text-center lg:text-left lg:text-2xl">EMERGENCY
            CONTACT DETAILS</p>
        <div class="lg:columns-3 lg:mt-3">
            <x-input-label for="eName" :value="__('Full Name:')" class="mt-2 lg:mt-0" />
            <x-text-input id="eName" class="block mt-1 w-full" type="text" name="eName"
                value="{{ isset($employee) ? $employee->eName : old('eName') }}" />
            @error('eName')
                <x-error>{{ $message }}</x-error>
            @enderror
            <x-input-label for="ePhone" :value="__('Phone No.:')" class="mt-2" />
            <x-text-input id="ePhone" class="block mt-1 w-full" type="text" name="ePhone"
                value="{{ isset($employee) ? $employee->ePhone : old('ePhone') }}" />
            @error('ePhone')
                <x-error>{{ $message }}</x-error>
            @enderror
            <x-input-label for="eAdd" :value="__('Address:')" class="mt-2" />
            <x-text-input id="eAdd" class="block mt-1 w-full" type="text" name="eAdd"
                value="{{ isset($employee) ? $employee->eAdd : old('eAdd') }}" />
            @error('eAdd')
                <x-error>{{ $message }}</x-error>
            @enderror
            <div class="flex items-center mt-1">
                <input id="eAddC" type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="eAddC"
                    class="ms-2 text-sm font-medium text-gray-900">Same Address</label>
            </div>
        </div>
        @if (isset($employee))
            <x-input-label for="remarks" :value="__('Remarks:')" class="mt-2" />
            <x-text-input id="remarks" class="block mt-1 w-full" type="text" name="remarks"
                value="{{ isset($employee) ? $employee->remarks : old('remarks') }}" required />
            @error('remarks')
                <x-error>{{ $message }}</x-error>
            @enderror
        @endif
    </div>

    <div class="flex justify-between lg:justify-start lg:gap-3 lg:flex-row-reverse">
        <button type="submit"
            class="w-1/2 focus:outline-none text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 my-3 lg:w-1/4">
            {{ isset($employee) ? __('Save') : __('Add') }}
        </button>
        @if (!isset($employee))
            <button type="button" id="clear"
                class="text-gray-900 border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-3">Clear</button>
        @endif
    </div>
</form>
