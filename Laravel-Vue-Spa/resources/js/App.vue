<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <img src="http://skhu.ac.kr/common/images/kseek/main_banner.jpg"><br>
            <h3 class="text-secondary">Laravel & Vue CRUD SPA by kth</h3>
            <a href=""><span class="text-secondary">my Git</span></a>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">Home</router-link>
                    <router-link to="/add" class="nav-item nav-link">Add Book</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>