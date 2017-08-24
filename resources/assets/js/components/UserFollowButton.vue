<template>
    <button class="btn btn-default"
            v-bind:class="{'btn-success':followed}" v-text="text" v-on:click="follow"></button>
</template>

<script>
    export default {
        props: ['user'],
        mounted() {
            // vue-resource实现ajax获取用户关注问题的状态
            this.$http.get('/api/user/followers/' + this.user).then(response => {
                this.followed = response.data.followed
            });
        },
        data(){
            return {
                followed: false
            }
        },
        computed: {
            text(){
                return this.followed ? '已关注' : '关注他'
            }
        },
        methods: {
            follow(){
                // 修改用户关注问题的状态
                this.$http.post('/api/user/follow',
                        {'user': this.user}).then(response => {
                    this.followed = response.data.followed
                });
            }
        }
    }
</script>
