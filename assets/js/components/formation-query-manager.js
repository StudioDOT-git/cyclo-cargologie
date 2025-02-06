export default class FormationQueryManager extends QueryManager {
  constructor (selector, templateSelector) {
    super(selector, templateSelector, 'formation', true)
  }
}
