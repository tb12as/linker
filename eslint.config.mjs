import pluginJs from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'
import globals from 'globals'


/** @type {import('eslint').Linter.Config[]} */
export default [
  {files: ['**/*.{js,mjs,cjs,vue}']},
  {languageOptions: { globals: globals.browser }},
  pluginJs.configs.recommended,
  ...pluginVue.configs['flat/essential'],
  ...pluginVue.configs['flat/recommended'],
  ...pluginVue.configs['flat/strongly-recommended'],
  {
    rules: {
      // 'prettier/prettier': 'error',
      // Best Practices
      'eqeqeq': 'off',
      'no-invalid-this': 'error',
      'no-return-assign': 'error',
      'no-unused-expressions': ['error', { allowTernary: true }],
      'no-useless-concat': 'error',
      'no-useless-return': 'error',

      // Variable
      'init-declarations': 'error',
      'no-use-before-define': 'error',
      'no-unused-vars': 'off',

      // Stylistic Issues
      'array-bracket-newline': ['error', { multiline: true, minItems: null }],
      'array-bracket-spacing': 'error',
      'brace-style': ['error', '1tbs', { allowSingleLine: true }],
      'block-spacing': 'error',
      'comma-dangle': 'error',
      'comma-spacing': 'error',
      'comma-style': 'error',
      'computed-property-spacing': 'error',
      'func-call-spacing': 'error',
      'implicit-arrow-linebreak': ['error', 'beside'],
      'indent': ['error', 2],
      'keyword-spacing': 'error',
      'multiline-ternary': ['error', 'never'],
      'no-lonely-if': 'error',
      'no-mixed-operators': 'error',
      'no-multiple-empty-lines': ['error', { max: 2, maxEOF: 1 }],
      'no-tabs': 'error',
      'no-unneeded-ternary': 'error',
      'no-whitespace-before-property': 'error',
      'nonblock-statement-body-position': 'error',
      'object-property-newline': ['error', { allowAllPropertiesOnSameLine: true }],
      'quote-props': ['error', 'consistent'],
      'quotes': ['error', 'single'],
      'semi': ['error', 'never'],
      'semi-spacing': 'error',
      'space-before-blocks': 'error',
      'space-before-function-paren': 'error',
      'space-in-parens': 'error',
      'space-infix-ops': 'error',
      'space-unary-ops': 'error',

      // ES6
      'arrow-spacing': 'error',
      'no-confusing-arrow': 'error',
      'no-duplicate-imports': 'error',
      'no-var': 'error',
      'object-shorthand': 'error',
      'prefer-const': 'error',
      'prefer-template': 'error',

      // Vue
      'vue/html-quotes': ['error', 'double']
    }
  }
]
