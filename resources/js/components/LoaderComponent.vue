<template>
    <div class="modal fade text-left" id="loader" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content-loader" style="border-radius: 130px;">
                <div class="modal-body">
                    <img src="/loader/loader-spin.gif" alt="" style="width:80px;"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    name: 'LoaderComponent',
    
}
</script>
