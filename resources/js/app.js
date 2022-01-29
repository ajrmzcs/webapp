
import Vue from 'vue'
import axios from 'axios'
import NavBarComponent from './components/NavBar/NavBarComponent'
import MainMenuComponent from './components/MainMenu/MainMenuComponent'
import HomeComponent from './components/Home/HomeComponent'

Vue.use(axios)

const app = new Vue({

    components: {
        NavBarComponent,
        MainMenuComponent,
        HomeComponent,
    },

    data() {
        return { }
    },

    mounted() { }

}).$mount("#app");

export default app;
