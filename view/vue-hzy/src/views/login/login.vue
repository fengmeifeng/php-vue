<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-20 15:02:52
 * @LastEditTime: 2020-04-21 16:28:18
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\views\login\login.vue
 -->
<template>
  <div class="login-container">
    <el-form
      :model="ruleForm"
      :rules="rules2"
      status-icon
      ref="ruleForm"
      label-position="left"
      label-width="0px"
      class="demo-ruleForm login-page"
    >
      <h3 class="title">系统登录</h3>
      <el-form-item prop="username">
          <el-input type="text" v-model="ruleForm.username" auto-complete="off" placeholder="用户名">
          </el-input>
      </el-form-item>
          <el-form-item prop="password">
              <el-input type="password" v-model="ruleForm.password" auto-complete="off" placeholder="密码"></el-input>
          </el-form-item>
      <el-checkbox
          v-model="checked"
          class="rememberme"
      >记住密码</el-checkbox>
      <el-form-item style="width:100%;">
          <el-button type="primary" style="width:100%;" @click="handleSubmit('ruleForm')" :loading="logining">登录</el-button>
      </el-form-item>
    </el-form>
	</div>
</template>
<script>
import { LOGIN } from '@/api/login/login'
import { postRequest } from '@/util/ajax'
import { successMessage, errorMessage } from '@/util/message'
export default {
  name: 'login',
  data () {
    return {
      logining: false,
      ruleForm: {
        username: '',
        password: ''
      },
      rules2: {
        username: [{required: true, message: '请输入账号', trigger: 'blur'}],
        password: [{required: true, message: '请输入密码', trigger: 'blur'}]
      },
      checked: false
    }
  },
  methods: {
    handleSubmit (formName) {
      this.$refs[formName].validate(valid => {
        valid && this.loginRequest()
      })
    },
    async loginRequest () {
      let [username, password] = [this.ruleForm.username, this.ruleForm.password]
      const { code, data, msg } = await postRequest(`${LOGIN}`, {
        username,
        password
      })
      if (code === 500) {
        return errorMessage(msg)
      }
      successMessage(msg)
      // this.$store.commit("saveToken", data.token);
      console.info(data)
      localStorage.setItem('token', data.token)
      localStorage.setItem('userInfor', JSON.stringify(data))
      this.$router.push({ name: 'layout' })
    }
  }
}
</script>
<style lang="less" scoped>
.login-container {
    width: 100%;
    height: 100%;
    background: #4373a5;
    /* 登录框上下对齐 */
    display: flex;
    align-items: center;
}
.login-page {
    -webkit-border-radius: 5px;
    border-radius: 5px;
    margin:0px auto;
    width: 350px;
    padding: 20px 35px 35px 15px;
    background: #fff;
    border: 1px solid #eaeaea;
    box-shadow: 0 0 25px #cac6c6;
}
label.el-checkbox.rememberme {
    margin: 0px 0px 15px;
    text-align: left;
}
.title {
  line-height: 60px;
  text-align: center;
}
</style>
