<template>
    <div class="card">
        <div
            class="card-header"
            :class="{
                'bg-success': cardType == 'success', 
                'bg-warning': cardType == 'warning',
                'bg-primary': cardType == 'primary',
                'bg-danger' : cardType == 'danger',
                'bg-dark' : cardType == 'dark'}"
        >
            <div class="row">
                <div class="col-5">
                    <span class="text-light">
                        <slot name="card-icon"></slot>
                    </span>
                </div>
                <div class="col-7">
                    <div class="row">
                        <div class="col">
                            <span class="float-right text-light">
                                <slot name="card-title"></slot>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3 class="float-right text-light">
                                <strong>
                                    <slot name="card-body"></slot>
                                </strong>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col">
                    <h5 class="text-secondary float-right pr-2 pt-2">
                        <slot name="card-footer"></slot>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "cardType"
    ]        
};
</script>
