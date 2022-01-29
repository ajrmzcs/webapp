<template>
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="/">
                        <h2 class="brand-text mb-0">voxie</h2>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" style="background-color: #202020;">
                <li class=" navigation-header">
                    <span style="font-weight:bold;" class="title-main-menu">NAVIGATION</span>
                </li>
                <li v-for="(value, index) in routes" :key="index" :class="`nav-item ${path === value.path ? 'active' : ''}`">
                    <a :href="value.href">
                        <i :class="value.icon"/>
                        <span class="menu-title title-main-submenu" v-html="value.name"/>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

import Resources from './resources'

export default {

    name:   'MainMenuComponent',
    
    props: [
        'path',
    ],
    
    data() {
        return {
            routes: Resources.routes
        }
    },

    methods: {
    },

    mounted() {
    }

}
</script>