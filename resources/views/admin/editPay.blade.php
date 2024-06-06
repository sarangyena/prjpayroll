<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="self-center font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Payroll') }}
            </h2>
            <a href="{{ route('a-payslip') }}">
                <button type="button"
                    class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center me-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">Cancel</button>
            </a>
        </div>
    </x-slot>

    <div class="py-6 lg:py-12">
        <div class="mx-auto lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    <p class="font-bold text-2xl border-b-2 border-green-300 text-center lg:text-left">EDIT PAYROLL</p>
                    @if (session('danger'))
                        <x-danger-alert />
                    @endif
                    <form method="POST" action="{{ route('a-updatePay', $payroll) }}" id="empForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="columns-2 mt-2">
                            <div>
                                <x-input-label for="pay_id" :value="__('Payroll ID:')" />
                                <x-text-input id="pay_id" class="block mt-1 w-full" type="text" name="pay_id"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->pay_id : null }}" />
                            </div>
                            <div>
                                <x-input-label for="user_name" :value="__('User ID:')" />
                                <x-text-input id="user_name" class="block mt-1 w-full" type="text" name="user_name"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->user_name : null }}" />
                            </div>
                        </div>
                        <div class="columns-2 mt-2">
                            <div>
                                <x-input-label for="name" :value="__('Name:')" class="" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->name : null }}" />
                            </div>
                            <div>
                                <x-input-label for="job" :value="__('Job:')" class="" />
                                <x-text-input id="job" class="block mt-1 w-full" type="text" name="job"
                                    readonly placeholder="{{ isset($payroll) ? $payroll->job : null }}" />
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
                                        name="days" placeholder="{{ isset($payroll) ? $payroll->days : null }}"
                                        readonly />
                                </div>
                                <div>
                                    <x-input-label for="late" :value="__('Late:')" />
                                    <x-text-input id="late" class="block mt-1 w-full salary" type="number"
                                        name="late" placeholder="{{ isset($payroll) ? $payroll->late : null }}"
                                        readonly />
                                </div>
                            </div>
                            <div class="mt-2">
                                <x-input-label for="salary" :value="__('Salary:')" />
                                <x-text-input id="salary" class="block mt-1 w-full total" type="text"
                                    name="salary" placeholder="{{ isset($payroll) ? $payroll->salary : null }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="border-2 border-green-300 p-3 mt-3 rounded-lg">
                            <div class="columns-2 text-nowrap">
                                <div>
                                    <x-input-label for="rph" :value="__('Rate Per Hour:')" />
                                    <x-text-input id="rph" class="block mt-1 w-full ot" type="number"
                                        name="rph" placeholder="{{ isset($payroll) ? $payroll->rph : null }}" />
                                </div>
                                <div>
                                    <x-input-label for="hrs" :value="__('Hours:')" />
                                    <x-text-input id="hrs" class="block mt-1 w-full ot" type="number"
                                        name="hrs" placeholder="{{ isset($payroll) ? $payroll->hrs : null }}"
                                        readonly />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="otpay" :value="__('Overtime Pay:')" class="mt-2" />
                                <x-text-input id="otpay" class="block mt-1 w-full total" type="text"
                                    name="otpay" placeholder="{{ isset($payroll) ? $payroll->otpay : null }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="border-2 border-green-300 p-3 mt-3 rounded-lg">
                            <div class="columns-2">
                                <div>
                                    <x-input-label for="holiday" :value="__('Holiday:')" />
                                    <x-text-input id="holiday" class="block mt-1 w-full total" type="number"
                                        name="holiday"
                                        placeholder="{{ isset($payroll) ? $payroll->holiday : null }}" />
                                </div>
                                <div>
                                    <x-input-label for="philhealth" :value="__('Philhealth:')" />
                                    <x-text-input id="philhealth" class="block mt-1 w-full deduction" type="number"
                                        name="philhealth"
                                        placeholder="{{ isset($payroll) ? $payroll->philhealth : null }}" />
                                </div>
                            </div>
                            <div class="columns-2 mt-2">
                                <div>
                                    <x-input-label for="sss" :value="__('SSS:')" />
                                    <x-text-input id="sss" class="block mt-1 w-full deduction" type="number"
                                        name="sss" placeholder="{{ isset($payroll) ? $payroll->sss : null }}" />
                                </div>
                                <div>
                                    <x-input-label for="advance" :value="__('Cash Advance:')" />
                                    <x-text-input id="advance" class="block mt-1 w-full deduction" type="number"
                                        name="advance"
                                        placeholder="{{ isset($payroll) ? $payroll->advance : null }}" />
                                </div>
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
                        <div>
                            <x-input-label for="remarks" :value="__('Remarks:')" />
                            <x-text-input id="remarks" class="block mt-1 w-full" type="text" name="remarks" 
                            placeholder="{{ isset($payroll) ? $payroll->remarks : null }}" required/>
                        </div>


                        <div class="flex justify-between lg:justify-start lg:gap-3 lg:flex-row-reverse">
                            <button type="submit"
                                class="w-1/2 focus:outline-none text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 my-3 lg:w-1/4">
                                {{ __('Save') }}
                            </button>
                            <button type="button" id="clear"
                                class="text-gray-900 border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-3">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            var num = null;

            function total() {
                num = null;
                var salary = $("#salary").val() == '' ? {{ $payroll->salary }} : Number($("#salary").val())
                var otpay = $("#otpay").val() == '' ? {{ $payroll->otpay }} : Number($("#otpay").val());
                var holiday = $("#holiday").val() == '' ? {{ $payroll->holiday }} : Number($("#holiday").val());
                num = salary + otpay + holiday;
                $('#gross').val(num);
                var gross = $("#gross").val() == '' ? {{ $payroll->gross }} : Number($("#gross").val());
                var deduction = $("#deduction").val() == '' ? {{ $payroll->deduction }} : Number($("#deduction")
                    .val());
                num = gross - deduction;
                $('#net').val(num);
            }
            /*function total() {
                num = null;
                var salary = $("#salary").val() == '' ? {{ $payroll->salary }} : Number($("#salary").val());
                var otpay = $("#otpay").val() == '' ? {{ $payroll->otpay }} : Number($("#otpay").val());
                var holiday = $("#holiday").val() == '' ? {{ $payroll->holiday }} : Number($("#holiday").val());
                num = salary + otpay + holiday;
                (salary === {{ $payroll->salary }} && otpay === {{ $payroll->otpay }} && holiday ===
                    {{ $payroll->holiday }}) ? $('#gross').val(''): $('#gross').val(num);
                var gross = $("#gross").val() == '' ? {{ $payroll->gross }} : Number($("#gross").val());
                var deduction = $("#deduction").val() == '' ? {{ $payroll->deduction }} : Number($("#deduction")
                    .val());
                num = gross - deduction;
                (gross === {{ $payroll->gross }} && deduction === {{ $payroll->deduction }}) ? $('#net').val(''):
                    $('#net').val(num);
            }*/
            $('#rate').on('input', function() {
                var rate = Number($(this).val());
                var days = {{ $payroll->days }};
                var late = {{ $payroll->late }};
                num = (rate * days) - (rate / 8 * late);
                $('#salary').val(num);
                var rph = (rate / 8) + (rate / 8) * 0.20;
                $('#rph').val(rph);
                var hrs = {{ $payroll->hrs }};
                num = rph * hrs;
                $('#otpay').val(num);
                if (rate == '') {
                    $('#otpay').val('');
                    $('#rph').val('');
                    $('#salary').val('');
                    $('#gross').val('');
                    $('#net').val('');
                } else {
                    total();
                }
            });
            /*$('.salary').on('input', function() {
                var rate = $(this).val();
                var rph = (rate/8)+(rate/8)*0.2;
                $('#rph').val(rph);
                var days = $("#days").val() == '' ? {{ $payroll->days }} : Number($("#days").val());
                var late = $("#late").val() == '' ? {{ $payroll->late }} : Number($("#late").val());
                num = (rate * days) - (rate / 8 * late);
                var hrs = $("#hrs").val() == '' ? {{ $payroll->hrs }} : Number($("#hrs").val());
                num = rph * hrs;
                (rph === {{ $payroll->rph }} && hrs === {{ $payroll->hrs }}) ? $('#otpay').val(''): $('#otpay').val(num);
                (late === {{ $payroll->late }} && days === {{ $payroll->days }} && rate ===
                    {{ $payroll->rate }}) ? $('#salary').val(''): $('#salary').val(num);
                
                if(rate == ''){
                    $('#salary').val('');
                    $('#rph').val('');
                    $('#otpay').val('');
                };
                total();
            });*/
            /*$('.ot').on('input', function() {
                var rph = $("#rph").val() == '' ? {{ $payroll->rph }} : Number($("#rph").val());
                
                total();
            });*/
            $('.deduction').on('input', function() {
                var philhealth = $("#philhealth").val() == '' ? {{ $payroll->philhealth }} : Number($(
                    "#philhealth").val());
                var sss = $("#sss").val() == '' ? {{ $payroll->sss }} : Number($("#sss").val());
                var advance = $("#advance").val() == '' ? {{ $payroll->advance }} : Number($("#advance")
                    .val());
                num = philhealth + sss + advance;
                $('#deduction').val(num);
                var gross = $("#gross").val() == '' ? {{ $payroll->gross }} : Number($("#gross").val());
                num = gross - Number($('#deduction').val());
                $('#net').val(num);
                if (philhealth == {{ $payroll->philhealth }} && sss == {{ $payroll->sss }} && advance ==
                    {{ $payroll->advance }}) {
                    $('#deduction').val('');
                    $('#net').val('');
                }
            });
            $('#holiday').on('input', function() {
                var holiday = $("#holiday").val() == '' ? {{ $payroll->holiday }} : Number($(this).val());
                var salary = $("#salary").val() == '' ? {{ $payroll->salary }} : Number($("#salary")
                    .val());
                var otpay = $("#otpay").val() == '' ? {{ $payroll->otpay }} : Number($("#otpay").val());
                num = salary + holiday + otpay;
                $('#gross').val(num);
                var gross = $("#gross").val() == '' ? {{ $payroll->gross }} : Number($("#gross").val());
                var deduction = $("#deduction").val() == '' ? {{ $payroll->deduction }} : Number($(
                    "#deduction").val());
                num = gross - deduction;
                $('#net').val(num);
                if ($('#gross').val() == {{ $payroll->gross }} && $('#net').val() ==
                    {{ $payroll->net }}) {
                    $('#gross').val('');
                    $('#net').val('');
                }

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
        });
    </script>
</x-app-layout>
