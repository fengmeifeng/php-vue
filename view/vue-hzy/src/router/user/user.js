/*
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:48:27
 * @LastEditTime: 2020-04-27 09:52:05
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\router\user\user.js
 */
const user = [
  {
    path: 'personalinfor',
    redirect: '/personalinfor/baseinfor',
    name: 'userManage',
    component: () =>
      import(
        /* webpackChunkName: "userManage" */ '../../views/user/user.vue'
      ),
    meta: [{ name: '首页', path: '/index' }, { name: '个人设置' }],
    children: [
      {
        path: '/personalinfor/baseinfor',
        name: 'baseInfor',
        component: () =>
          import(
            /* webpackChunkName: "baseInfor" */ '../../views/user/base/base.vue'
          ),
        meta: [{ name: '首页', path: '/index' }, { name: '基本信息' }]
      },
      {
        path: '/personalinfor/securitysetting',
        name: 'securitySetting',
        component: () =>
          import(
            /* webpackChunkName: "securitySetting" */ '../../views/user/set/set.vue'
          ),
        meta: [{ name: '首页', path: '/index' }, { name: '安全设置' }]
      },
      {
        path: '/personalinfor/loginglogs',
        name: 'loginLogs',
        component: () =>
          import(
            /* webpackChunkName: "loginLogs" */ '../../views/user/logs/logs.vue'
          ),
        meta: [{ name: '首页', path: '/index' }, { name: '登陆日志' }]
      }
    ]
  }
]
export default user
