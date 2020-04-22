/*
 * @Author: your name
 * @Date: 2020-04-20 14:23:11
 * @LastEditTime: 2020-04-22 09:43:23
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\config\dev.env.js
 */
'use strict'
const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"dev"',
  API_HOST: '"http://localhost:8020"'
});
