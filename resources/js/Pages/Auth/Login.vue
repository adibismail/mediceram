<template>
<!-- <title>Login - Mediceram</title> -->
    <div>
        <!-- <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
            {{ test }}
        </div> -->

        <!-- <inertia-link :href="route('logout')" method="post">Logout</inertia-link> -->
        
        
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="row w-100 m-0">
                    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                        <div class="card col-lg-4 mx-auto">
                            <div class="card-body px-5 py-5">
                                <h3 class="card-title text-left mb-3">Login</h3>
                                <form action="/login" @submit.prevent="submit">
                                    <div class="form-group">
                                        <label>Username or email *</label>
                                        <input v-model="form.email" type="text" class="form-control p_input"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input v-model="form.password" type="password" class="form-control p_input"/>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block enter-btn">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</template>

<script>
export default {
    metaInfo: { title: "Login" },
    //props: ["test"],
    props: {
        errors: Object,
    },
    data() {
        return {
            form: {
                email: "admin@gg.com",
                password: "12345678",
            },
        }
    },
    methods: {
        submit() {
            const data = {
                email: this.form.email,
                password: this.form.password,
            
            }

            console.log(this.route('login'))
            this.$inertia.post(this.route('login'), data)
        },
    },
};
</script>
