import {createRouter, createWebHistory} from 'vue-router';
import NotFound from "@/views/NotFound";
import MainLayout from "@/layouts/MainLayout";
import MainView from "@/views/MainView";
import EventAbout from "@/views/event/EventAbout";
import EventList from "@/views/event/EventList";
import TestView from "@/views/TestView";

const routes = [{
    component: MainLayout, path: "/", children: [{
        path: "/home", name: "home", alias: '/', component: MainView,
    }, {
        path: "/event/information", name: "event_general_information", component: EventAbout,
    }, {
        path: "/event/list", name: "event_list", component: EventList,
    }, {
        path: "/about", name: "about", component: TestView,
    }, {
        path: "/discord", name: "discord", beforeEnter() {location.href = 'https://discord.gg/VjrfCFKRgR'},
    },{
        path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound,
    },],
},

];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL), routes,
});

export default router;
