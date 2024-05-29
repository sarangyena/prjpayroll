<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="self-center font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Payroll') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300">EDIT PAYROLL</p>
                    @if (session('danger'))
                        <x-danger-alert />
                    @endif
                    <form method="POST" action="{{ route('a-updatePay', $payroll) }}" id="empForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="columns-4 pt-2">
                            <div>
                                <x-input-label for="pay_id" :value="__('Payroll ID:')" />
                                <x-text-input id="pay_id" class="block mt-1 w-full" type="text" name="pay_id"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->pay_id : null }}" readonly />
                            </div>
                            <div>
                                <x-input-label for="user_name" :value="__('User ID:')" />
                                <x-text-input id="user_name" class="block mt-1 w-full" type="text" name="user_name"
                                    placeholder="{{ isset($payroll) ? $payroll->user_name : null }}" readonly />
                            </div>
                            <div>
                                <x-input-label for="name" :value="__('Name:')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->name : null }}" readonly />
                            </div>
                            <div>
                                <x-input-label for="job" :value="__('Job:')" />
                                <x-text-input id="job" class="block mt-1 w-full" type="text" name="job"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->job : null }}" readonly />
                            </div>
                        </div>
                        <div class="border-2 mt-3 border-green-300 rounded-lg p-3">
                            <div class="columns-3">
                                <div>
                                    <x-input-label for="rate" :value="__('Rate:')" />
                                    <x-text-input id="rate" class="block mt-1 w-full salary" type="number"
                                        name="rate" placeholder="{{ isset($payroll) ? $payroll->rate : null }}" />
                                </div>
                                <div>
                                    <x-input-label for="days" :value="__('Days:')" />
                                    <x-text-input id="days" class="block mt-1 w-full salary" type="number"
                                        name="days" placeholder="{{ isset($payroll) ? $payroll->days : null }}" />
                                </div>
                                <div>
                                    <x-input-label for="late" :value="__('Late:')" />
                                    <x-text-input id="late" class="block mt-1 w-full salary" type="number"
                                        name="late" placeholder="{{ isset($payroll) ? $payroll->late : null }}" />
                                </div>
                            </div>
                            <div class="mt-2">
                                <x-input-label for="salary" :value="__('Salary:')" />
                                <x-text-input id="salary" class="block mt-1 w-full total" type="text"
                                    name="salary" placeholder="{{ isset($payroll) ? $payroll->salary : null }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="columns-3 border-2 border-green-300 p-3 mt-3 rounded-lg">
                            <div>
                                <x-input-label for="rph" :value="__('Rate Per Hour:')" />
                                <x-text-input id="rph" class="block mt-1 w-full ot" type="number" name="rph"
                                    placeholder="{{ isset($payroll) ? $payroll->rph : null }}" />
                            </div>
                            <div>
                                <x-input-label for="hrs" :value="__('Hours:')" />
                                <x-text-input id="hrs" class="block mt-1 w-full ot" type="number" name="hrs"
                                    placeholder="{{ isset($payroll) ? $payroll->hrs : null }}" />
                            </div>
                            <div>
                                <x-input-label for="otpay" :value="__('Overtime Pay:')" />
                                <x-text-input id="otpay" class="block mt-1 w-full total" type="text"
                                    name="otpay" placeholder="{{ isset($payroll) ? $payroll->otpay : null }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="columns-4 mt-2 border-2 border-green-300 p-3 rounded-lg">
                            <div>
                                <x-input-label for="holiday" :value="__('Holiday:')" />
                                <x-text-input id="holiday" class="block mt-1 w-full total" type="number"
                                    name="holiday" placeholder="{{ isset($payroll) ? $payroll->holiday : null }}" />
                            </div>
                            <div>
                                <x-input-label for="philhealth" :value="__('Philhealth:')" />
                                <x-text-input id="philhealth" class="block mt-1 w-full deduction" type="number"
                                    name="philhealth"
                                    placeholder="{{ isset($payroll) ? $payroll->philhealth : null }}" />
                            </div>
                            <div>
                                <x-input-label for="sss" :value="__('SSS:')" />
                                <x-text-input id="sss" class="block mt-1 w-full deduction" type="number"
                                    name="sss" placeholder="{{ isset($payroll) ? $payroll->sss : null }}" />
                            </div>
                            <div>
                                <x-input-label for="advance" :value="__('Cash Advance:')" />
                                <x-text-input id="advance" class="block mt-1 w-full deduction" type="number"
                                    name="advance" placeholder="{{ isset($payroll) ? $payroll->advance : null }}" />
                            </div>
                        </div>
                        <div class="columns-3 mt-2">
                            <div>
                                <x-input-label for="gross" :value="__('Gross Pay:')" />
                                <x-text-input id="gross" class="block mt-1 w-full total" type="text"
                                    name="gross" readonly
                                    placeholder="{{ isset($payroll) ? $payroll->gross : null }}" readonly />
                            </div>
                            <div>
                                <x-input-label for="deduction" :value="__('Deduction:')" />
                                <x-text-input id="deduction" class="block mt-1 w-full total" type="text"
                                    name="deduction" readonly
                                    placeholder="{{ isset($payroll) ? $payroll->deduction : null }}" readonly />
                            </div>
                            <div>
                                <x-input-label for="net" :value="__('Net Pay:')" />
                                <x-text-input id="net" class="block mt-1 w-full total" type="text"
                                    name="net" readonly
                                    placeholder="{{ isset($payroll) ? $payroll->net : null }}" readonly />
                            </div>
                        </div>

                        <div class="flex mt-2 flex-row-reverse">
                            <x-primary-button class="m-3">
                                {{ isset($payroll) ? __('Save') : __('Add') }}
                            </x-primary-button>
                            @if (!isset($payroll))
                                <x-secondary-button id="clear" class="m-3">
                                    {{ __('Clear') }}
                                </x-secondary-button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var num = null;

            function total() {
                num = null;
                var salary = $("#salary").val() == '' ? {{ $payroll->salary }} : Number($("#salary").val());
                var otpay = $("#otpay").val() == '' ? {{ $payroll->otpay }} : Number($("#otpay").val());
                var holiday = $("#holiday").val() == '' ? {{ $payroll->holiday }} : Number($("#holiday").val());
                num = salary + otpay + holiday;
                console.log(otpay);
                (salary === {{ $payroll->salary }} && otpay === {{ $payroll->otpay }} && holiday ===
                    {{ $payroll->holiday }}) ? $('#gross').val('') : $('#gross').val(num);
                var gross = $("#gross").val() == '' ? {{ $payroll->gross }} : Number($("#gross").val());
                var deduction = $("#deduction").val() == '' ? {{ $payroll->deduction }} : Number($("#deduction").val());
                num = gross - deduction;
                (gross === {{ $payroll->gross }} && deduction === {{ $payroll->deduction }}) ? $('#net').val('') : $('#net').val(num);
            }
            $('.salary').on('input', function() {
                var rate = $("#rate").val() == '' ? {{ $payroll->rate }} : Number($("#rate").val());
                var days = $("#days").val() == '' ? {{ $payroll->days }} : Number($("#days").val());
                var late = $("#late").val() == '' ? {{ $payroll->late }} : Number($("#late").val());
                num = (rate * days) - (rate / 8 * late);
                (late === {{ $payroll->late }} && days === {{ $payroll->days }} && rate ===
                    {{ $payroll->rate }}) ? $('#salary').val('') : $('#salary').val(num);
                total();
            });
            $('.ot').on('input', function() {
                var rph = $("#rph").val() == '' ? {{ $payroll->rph }} : Number($("#rph").val());
                var hrs = $("#hrs").val() == '' ? {{ $payroll->hrs }} : Number($("#hrs").val());
                num = rph * hrs;
                (rph === {{ $payroll->rph }} && hrs === {{ $payroll->hrs }}) ? $('#otpay').val('') : $('#otpay').val(num);
                total();
            });
            $('.deduction').on('input', function() {
                var philhealth = $("#philhealth").val() == '' ? {{ $payroll->philhealth }} : Number($("#philhealth").val());
                var sss = $("#sss").val() == '' ? {{ $payroll->sss }} : Number($("#sss").val());
                var advance = $("#advance").val() == '' ? {{ $payroll->advance }} : Number($("#advance").val());
                num = philhealth + sss + advance;
                (philhealth === {{ $payroll->philhealth }} && sss === {{ $payroll->sss }} && advance === {{ $payroll->advance }}) ? $('#deduction').val('') : $('#deduction').val(num);
                total();
            });
            $('#holiday').on('input', function() {
                total();
            });
            $("input[type='number']").on("keypress", function(e) {
                // Allow numbers (0-9), decimal point (.), negative sign (-)
                if (e.which != 8 && // Backspace
                    e.keyCode != 0 && // Tab
                    (e.keyCode < 48 || e.keyCode > 57) && // Not numbers (0-9)
                    e.keyCode != 46 && // Not decimal point (.)
                    (e.keyCode != 101 && e.keyCode != 69) // Not exponent (e or E)
                ) {
                    e.preventDefault();
                }
            });
            $('input[type="text"], input[type="number"]').on('change', function() {
                var currentValue = $(this).val();
                if (currentValue === "0") {
                    $(this).val("");
                }
            });
        });
    </script>
</x-app-layout>
