
//无限递归所有路由生成树形结构
const layouts = require.context('../layouts', false, /\.vue$/)
const views = require.context('../views', true, /\.vue$/)
import routeTool from './tools'
let tool = new routeTool()

import NotFound from '../views/NotFound.vue'
let rootLayoutRoutes = []
/**
 * 生成根布局路由
 */
rootLayoutRoutes = tool.getRootLayoutRoutes(layouts)
/**
 *
 * 格式化路由
 * @returns
 */

let flatRoutes = tool.formatViewsRoutes(views)

//获取所有一维路由
const allRoutes = [...rootLayoutRoutes, ...flatRoutes]


//生成树形路由结构
let treeRoutes = rootLayoutRoutes.map(route => tool.generateTreeComponent(route, allRoutes))



//添加404页面
const notFound = {
    path: '/:pathMatch(.*)*',
    name: 'notfound',
    component: NotFound
}
treeRoutes.push(notFound)

export default treeRoutes
