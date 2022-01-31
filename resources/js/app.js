require('./bootstrap');
import Vue from 'vue'
import NavBarComponent from './components/NavBar/NavBarComponent'
import MainMenuComponent from './components/MainMenu/MainMenuComponent'
import HomeComponent from './components/Home/HomeComponent'
import ShowRecordsComponent from './components/ShowRecords/ShowRecordsComponent'

const app = new Vue({

    components: {
        NavBarComponent,
        MainMenuComponent,
        HomeComponent,
        ShowRecordsComponent,
    },

    data() {
        return { }
    },

    mounted() { }

}).$mount("#app");

export default app;
