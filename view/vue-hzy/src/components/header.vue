<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:11:54
 * @LastEditTime: 2020-04-21 16:31:24
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\components\header.vue
 -->
<template>
  <div class="main">
    <div class="left c-fff">后台管理系统</div>
    <div class="right">
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
    <div class="right c-fff m-r-10"><span>您好，{{ userName }}</span></div>
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
      userName: '管理员',
      headerImg: 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1587447090979&di=15927a9e64433c67e87dc7b02f4b1724&imgtype=0&src=http%3A%2F%2Fimgsrc.baidu.com%2Fforum%2Fpic%2Fitem%2Fad1e93b2551ca64713df9b13.jpg%3Fv%3Dtbs'
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
  }
}
</script>
<style scoped>
.m-r-10 {
  margin-right: 10px;
}
.c-fff {
  color: #fff;
}
.left {
  float: left;
}
.right {
  float: right;
}
img {
  vertical-align: middle;
  border-radius: 50%;
}
.el-dropdown {
  color: #fff;
}
</style>
