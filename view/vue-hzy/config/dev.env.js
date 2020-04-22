/*
 * @Author: your name
 * @Date: 2020-04-20 14:23:11
 * @LastEditTime: 2020-04-21 15:48:38
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\config\dev.env.js
 */
'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"dev"',
  VUE_APP_BASE_URL: '"http://localhost:8020"'
});
