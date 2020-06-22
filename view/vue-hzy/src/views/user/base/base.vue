<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-27 09:38:53
 * @LastEditTime: 2020-04-28 09:14:10
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \php-vue\view\vue-hzy\src\views\user\base\base.vue
 -->
<template>
  <div class="baseinfo">
    <!-- <h3>基本资料</h3> -->
    <div class="baseinfo-content">
      <el-form
        :model="ruleForm"
        :rules="rules"
        ref="ruleForm"
        label-width="100px"
        class="demo-ruleForm"
      >
        <el-form-item>
          <div class="baseinfo-content_avatar">
            <el-avatar
              icon="el-icon-user-solid"
              :size="100"
              fit="fill"
              :src="avatarUrl"
            ></el-avatar>

            <p>
              <el-button size="medium" @click="uploadAvatar()"
                >修改头像</el-button
              >
            </p>
          </div>
        </el-form-item>
        <el-form-item label="用户名">
          <el-input v-model="uname" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item label="姓名" prop="name">
          <el-input v-model="ruleForm.name"></el-input>
        </el-form-item>
        <el-form-item label="性别" prop="sex">
          <el-select
            v-model="ruleForm.sex"
            placeholder="请选择性别"
            class="baseinfo-content--select"
          >
            <el-option label="保密" value="S"></el-option>
            <el-option label="男" value="M"></el-option>
            <el-option label="女" value="F"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="职位" prop="job">
          <el-input v-model="ruleForm.job"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="update('ruleForm')">保 存</el-button>
        </el-form-item>
      </el-form>
    </div>
    <uploadAvatar
      ref="uploadAvatar"
      :url="ruleForm.avatarUrl"
      @info="getUserInfo"
    ></uploadAvatar>
  </div>
</template>
<script>
import { USERINFO } from '@/api/layout/layout'
import { UPDATE } from '@/api/user/base/base'
import { getRequest, postRequest } from '@/util/ajax'
import { successMessage, errorMessage } from '@/util/message'

import uploadAvatar from './uploadavatar.vue'
export default {
  name: 'base',
  components: {
    uploadAvatar
  },
  data () {
    return {
      uname: '', // 用户名
      avatarUrl: '', // 头像全地址
      ruleForm: {
        name: '',
        sex: '',
        job: ''
      },
      rules: {
        name: [{ required: true, message: '请输输入姓名', trigger: 'blur' }]
      }
    }
  },
  methods: {
    // 获取信息列表
    async getUserInfo () {
      const { code, msg, data } = await getRequest(USERINFO)
      if (code === 500) {
        return errorMessage(msg)
      }
      console.info(data)
      if (data.avatarUrl) {
        this.avatarUrl = process.env.VUE_APP_BASE_URL + data.avatarUrl
        console.info(this.avatarUrl)
      }
      this.ruleForm.name = data.name
      this.ruleForm.sex = data.sex
      this.ruleForm.job = data.job

      // 用户名
      this.uname = data.userName
    },
    // 修改头像弹框
    uploadAvatar () {
      this.$refs.uploadAvatar.show(this.ruleForm.id)
    },
    // 保存
    async update (formName) {
      this.$refs[formName].validate(async valid => {
        const { code, msg, data } = await getRequest(UPDATE, this.ruleForm)
        if (code === 500) {
          return errorMessage(msg)
        }
        this.getUserInfo()
        successMessage(msg)
      })
    }
  },
  mounted () {
    this.getUserInfo()
  }
}
</script>
<style lang="less" scoped>
@import "../../../assets/styles/less/atom.less";
.baseinfo {
  padding-top: 40px;
}
.baseinfo-content {
  width: 85%;
  margin: 0px auto;
}
.baseinfo-content--select {
  width: 100%;
}
.baseinfo-content_avatar {
  width: 300px;
  margin: 0px auto;
}
/deep/ .el-avatar {
  font-size: 60pt;
}
</style>
