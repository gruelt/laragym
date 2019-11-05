<template>
    <div>
        <div v-if="admin">

            {{display}} &nbsp;<i class="fas fa-pen fa-xs" @click="$bvModal.show('modal-'+model+'-'+field)"></i>&nbsp;&nbsp;<span :class="icon"></span>


            <b-modal :id="'modal-'+model+'-'+field" title="Modifier" hide-footer>
                <b-form-input :type="type" v-model="value" placeholder=""></b-form-input>


                <b-button @click="pushupdate();$bvModal.hide('modal-'+model+'-'+field);"  variant="success">Ok</b-button>
            </b-modal>
        </div>
    <div v-else>
        {{display}}
    </div>
    </div>
</template>

<script>
    export default {
        props:{
            id:{
                type: Number,
                required: true
            },
            field:{
                type: String,
                required:true
            },
            model:{
                type: String,
                required: true
            },
            value:{
                type:String,
                required: true
            },
            type:{
                type: String,
                default: "text"
            },
            admin:{
                type:Boolean,
                default:false
            },
            icon:{
                type:String,
                default: ""
            },
            display:{
                type:String,
                default:""
            }

        },
        methods: {

            toggle(form){
                console.log(form);
            },

            pushupdate: function() {
                axios
                    .post('/api/admin/model/'+ this.model+'/'+this.id+'/'+this.field ,  { value: this.value })
                    .then(response => (this.fields = response.data));
                console.log('Update '+this.id + this.model + this.field+this.value);

                location.reload();
                // if(this.type=="date")
                // {
                //     location.reload();
                // }


            },



        },

        mounted(){

            if(this.display=="")
            {

                this.display=this.value;
                console.log(display+value);
            }
        }
    }
</script>
