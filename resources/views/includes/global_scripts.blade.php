<script>var hostUrl = "{{url('/')}}/assets/";</script>
<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{url('/')}}/assets/plugins/global/plugins.bundle.js"></script>
<script src="{{url('/')}}/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->

<script>
    function updateCountTask() {
        $.get('{{url('/')}}/tasks/unfinished', function (res) {

            if(res.count > 0){
                $('#countTask').show().html(res.count);
            } else {
                $('#countTask').hide();
            }
        })
    }

    updateCountTask();
    setInterval(function () {
        updateCountTask();
    }, 60000)
</script>
