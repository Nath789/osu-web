###
#    Copyright (c) ppy Pty Ltd <contact@ppy.sh>.
#
#    This file is part of osu!web. osu!web is distributed with the hope of
#    attracting more community contributions to the core ecosystem of osu!.
#
#    osu!web is free software: you can redistribute it and/or modify
#    it under the terms of the Affero GNU General Public License version 3
#    as published by the Free Software Foundation.
#
#    osu!web is distributed WITHOUT ANY WARRANTY; without even the implied
#    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
#    See the GNU Affero General Public License for more details.
#
#    You should have received a copy of the GNU Affero General Public License
#    along with osu!web.  If not, see <http://www.gnu.org/licenses/>.
###

class @StoreSupporterTag
  RESOLUTION: 8
  MIN_VALUE: 4
  MAX_VALUE: 52

  @initialize: ->
    new StoreSupporterTag(elem) for elem in document.getElementsByClassName('js-store-supporter-tag')

  constructor: (rootElement) ->
    @debouncedGetUser = _.debounce @getUser, 300
    @el = rootElement
    @searching = false
    @user = JSON.parse(@el.dataset.user ? 'null') ? window.currentUser
    delete @el.dataset.user

    $(document).on 'turbolinks:before-cache', =>
      @el.dataset.user = JSON.stringify(@user)

    # Everything should be scoped under the root @el
    @priceElement = @el.querySelector('.js-price')
    @durationElement = @el.querySelector('.js-duration')
    @discountElement = @el.querySelector('.js-discount')
    @slider = @el.querySelector('.js-slider')
    @sliderPresets = @el.querySelectorAll('.js-slider-preset')
    @targetIdElement = @el.querySelector('input[name="item[extra_data][target_id]"]')
    @usernameInput = @el.querySelector('.js-username-input')

    @cost = @calculate(@initializeSlider().slider('value'))
    @initializeSliderPresets()
    @initializeUsernameInput()
    @updateCostDisplay()

    @updateTargetId() # force target_id for consistency.
    @setUserInteraction(@user?.id?)


  initializeSlider: =>
    # remove leftover from previous initialization
    $(@slider).find('.ui-slider-range').remove()

    $(@slider).slider
      range: 'min'
      value: @slider.dataset.lastValue ? @sliderValue(@MIN_VALUE)
      min: @sliderValue(@MIN_VALUE)
      max: @sliderValue(@MAX_VALUE)
      step: 1
      animate: true
      slide: @onSliderValueChanged
      change: @onSliderValueChanged

  initializeSliderPresets: =>
    $(@sliderPresets).on 'click', (event) =>
      target = event.currentTarget
      price = StoreSupporterTagPrice.durationToPrice(target.dataset.months)
      $(@slider).slider('value', @sliderValue(price)) if price

  initializeUsernameInput: =>
    $(@usernameInput).on 'input', @onInput

  getUser: (username) =>
    if !username # reset to current user on empty
      @user = window.currentUser
      @searching = false
      @updateSearchResult()
      return

    $.ajax
      data:
        username: username
      dataType: 'json',
      type: 'POST'
      url: laroute.route('users.check-username-exists')
    .done (data) =>
      @user = data

    .fail (xhr) =>
      @user = null
      if xhr.status == 401
        osu.popup osu.trans('errors.logged_out'), 'danger'

    .always =>
      @searching = false
      @updateSearchResult()

  calculate: (position) =>
    new StoreSupporterTagPrice(Math.floor(position / @RESOLUTION))

  onSliderValueChanged: (event, ui) =>
    @slider.dataset.lastValue = ui.value
    @cost = @calculate(ui.value)
    @updateCostDisplay()

  onInput: (event) =>
    if !@searching
      @searching = true
      @updateSearchResult()
    @debouncedGetUser(event.currentTarget.value)

  setUserInteraction: (enabled) =>
    StoreCart.setEnabled(enabled)
    # TODO: need to elevate this element when switching over to new store design.
    $(@el).toggleClass('js-store--disabled', !enabled)
    $('.js-slider').slider('disabled': !enabled)

  sliderValue: (price) ->
    price * @RESOLUTION

  updateSearchResult: =>
    if @searching
      $.publish 'store-supporter-tag:update-user', null
      return @setUserInteraction(false)

    $.publish 'store-supporter-tag:update-user', @user
    @updateTargetId()
    @setUserInteraction(@user?.id?)

  updateCostDisplay: =>
    @el.querySelector('input[name="item[cost]"]').value = @cost.price()
    @priceElement.textContent = "USD #{@cost.price()}"
    @durationElement.textContent = @cost.durationText()
    @discountElement.textContent = @cost.discountText()
    @updateSliderPreset(elem, @cost) for elem in @sliderPresets

  updateSliderPreset: (elem, cost) ->
    $(elem).toggleClass('js-slider-preset--active', cost.duration() >= +elem.dataset.months)

  updateTargetId: =>
    @targetIdElement.value = @user?.id
