<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:11:54
 * @LastEditTime: 2020-04-23 09:20:05
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\components\header.vue
 -->
<template>
  <div class="main">
    <div class="left t-c width-170">后台管理系统</div>
    <div class="right m-r-10">
      <el-dropdown>
        <div>
          <img
            :src="headerImg"
            alt
            width="40px"
            height="40px"
            style="background: 100%"
          />
          <i class="el-icon-arrow-down el-icon--right"></i>
        </div>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item @click.native="jumpPersonal()"
            >个人信息</el-dropdown-item
          >
          <el-dropdown-item @click.native="exit()">退出登录</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
    <div class="right m-r-10"><span>您好，{{ userName }}</span></div>
  </div>
</template>
<script>
import { LOGIN_OUT } from '@/api/login/login'
import { postRequest } from '@/util/ajax'
import { successMessage, errorMessage } from '@/util/message'
export default {
  name: 'headerMain',
  data () {
    return {
      activeIndex: '1',
      userName: '',
      headerImg: 'http://5b0988e595225.cdn.sohucs.com/q_70,c_zoom,w_640/images/20190207/df71e02d3f4948a58884fab5f16054e0.jpeg'
    }
  },
  methods: {
    // 跳转
    jumpPersonal () {
      console.log('个人信息')
      this.$router.push({ path: '/personalinfor/baseinfor' })
    },
    async exit () {
      const result = await this.exitRequest()
      console.info(result)
      if (result === 200) {
        localStorage.clear()
        sessionStorage.clear()
        this.$router.push({ name: 'login' })
      }
    },
    async exitRequest () {
      const { code } = await postRequest(LOGIN_OUT)
      return code
    }
  },
  mounted () {
    this.userName = JSON.parse(localStorage.getItem('userInfor')).name
  }
}
</script>
<style lang="less" scoped>
@import "../assets/styles/less/atom.less";
img {
  vertical-align: middle;
  border-radius: 50%;
}
</style>
