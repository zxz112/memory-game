import VueRouter from 'vue-router'
import Game from "./components/Game";
import DashBoardList from "./components/dashboard/DashBoardList";

const routes = [
    {
        path: '/',
        component: Game,
        name: 'game'
    },
    {
        path: '/results',
        component: DashBoardList,
        name: 'result'
    },
];

const router = new VueRouter({
    routes,
    mode: 'history'
});

export default router;
