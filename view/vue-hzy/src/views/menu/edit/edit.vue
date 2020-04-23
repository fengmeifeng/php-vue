/* eslint-disable camelcase */
<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-23 15:39:43
 * @LastEditTime: 2020-04-23 16:52:33
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\views\menu\edit\edit.vue
 -->
<template>
  <div>
    <el-dialog
      :title="title"
      :visible.sync="isShow"
      v-if="isShow"
      :show-close="true"
      :close-on-click-modal="true"
      :close-on-press-escape="true"
    >
      <div class="content">
        <el-form
          :model="ruleForm"
          ref="ruleForm"
          :rules="rules"
          label-width="90px"
        >
          <el-form-item label="栏目名称:" prop="name">
            <el-input
              v-model="ruleForm.name"
              placeholder="请输入栏目名称"
            ></el-input>
          </el-form-item>
          <el-form-item label="栏目地址:" prop="path">
            <el-input
              v-model="ruleForm.path"
              placeholder="请输入栏目地址"
            ></el-input>
          </el-form-item>
          <el-form-item label="icon:" prop="icon">
            <el-input
              v-model="ruleForm.icon"
              placeholder="icon"
            ></el-input>
          </el-form-item>
          <el-form-item label="英文:" prop="yingwen">
            <el-input
              v-model="ruleForm.yingwen"
              placeholder="请输入英文"
            ></el-input>
          </el-form-item>
            <el-form-item label="是否是按钮" prop="isbut">
              <el-radio-group v-model="ruleForm.isbut">
                <el-radio :label="0">否</el-radio>
                <el-radio :label="1">页面按钮</el-radio>
                <el-radio :label="2">列表按钮</el-radio>
              </el-radio-group>
            </el-form-item>
          <el-form-item label="备注:" prop="remarks">
            <el-input
              type="textarea"
              v-model="ruleForm.remarks"
              placeholder="请填写备注"
            ></el-input>
          </el-form-item>
        </el-form>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('ruleForm')">取 消</el-button>
        <el-button type="primary" @click="onSubmit('ruleForm')">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import { UPDATE } from '@/api/menu/edit/edit'
import { DETAIL } from '@/api/menu/menu'
import { getRequest, postRequest } from '@/util/ajax'
import { successMessage, errorMessage } from '@/util/message'
export default {
  name: 'editMenu',
  data () {
    return {
      id: 0,
      title: '编辑栏目',
      isShow: false,
      ruleForm: {
        cid: 0,
        pid: 0,
        name: '',
        path: '',
        icon: '',
        yingwen: '',
        isbut: 0,
        remarks: ''
      },
      rules: {
        name: [
          { required: true, message: '请输入栏目名称', trigger: 'blur' },
          { min: 1, max: 60, message: '栏目名称长度在1~60个字符之间' }
        ],
        path: [
          { required: true, message: '请输入栏目地址', trigger: 'blur' }
        ]
      }
    }
  },
  methods: {
    async detail () {
      const { code, msg, data } = await getRequest(DETAIL, {id: this.id})
      if (code === 200) {
        this.ruleForm = data
      }
    },
    // 显示
    show (id) {
      console.info(id)
      id && (this.id = id)
      this.detail()
      this.isShow = true
    },
    cancel (formName) {
      this.isShow = false
      this.$refs[formName].resetFields()
    },
    onSubmit (formName) {
      this.$refs[formName].validate(async valid => {
        if (valid) {
          console.info(this.ruleForm)
          const { code, msg } = await postRequest(UPDATE, this.ruleForm)
          if (code === 500) {
            return errorMessage(msg)
          }
          successMessage(msg)
          this.cancel(formName)
          this.$emit('lists', 1)
        }
      })
    }
  }
}
</script>
<style lang="less" scoped>
</style>
