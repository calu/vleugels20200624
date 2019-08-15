<template>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <img :src="image" class="img-responsive">
            </div>
            <div class="col-md-8">
                <input type="file" v-on:change="onFileChange" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-success btn-block" @click="upload">Upload</button>
            </div>
        </div>
    </div>
</template>
<style scoped>
    img{
        max-height: 36px;
    }
</style>
<script>
    export default{
        data(){
            return {
                image: '',
                name: ''
            }
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                this.name=file['name']; 
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            upload(){
                axios.post('/upload',{ image: this.image, name: this.name })
                    .then( response => this.$emit('fotobestand', this.name));
            } 
        } 
    }
</script>