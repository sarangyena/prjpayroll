<x-app-layout>
    @include('partials._qrview')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script type="application/javascript">
        $(document).ready(function(){
            $('#r').hide();
            $('#search').on('input', function() {
                var inputValue = $(this).val().toUpperCase();
                $('#view tbody tr').filter(function() {
                    $(this).toggle($(this).text().indexOf(inputValue) > -1);
                });
            });
            $('.datepicker-picker').click(function() {
                if($('#dateType').val() == 'range'){
                    if($('#start').val() != $('#end').val()){
                        var data = [
                            $('#start').val(),
                            $('#end').val(),
                        ] 
                        window.location.href = '/user/qrView?range=' + encodeURIComponent(JSON.stringify(data));
                    }
                }else if($('#dateType').val() == 'date'){
                    if($('#date').val() != ''){
                        var date = $('#date').val();
                        window.location.href = '/user/qrView?date=' + encodeURIComponent(date);                    
                    }
                    
                }
            });
            $('#dateType').on('change', function() {
                var val = $(this).val();
                if(val == 'date'){
                    $('#dateType').removeClass('w-1/4');
                    $('#dateType').addClass('w-1/2');
                    $('#r').hide();
                    $('#d').show();
                }else if(val == 'range'){
                    $('#dateType').removeClass('w-1/3');
                    $('#dateType').addClass('w-1/4');
                    $('#d').hide();
                    $('#r').show();
                }
            });
        });
    </script>
</x-app-layout>
