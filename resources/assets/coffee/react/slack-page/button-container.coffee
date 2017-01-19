###
#    Copyright 2015-2017 ppy Pty. Ltd.
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

{div, p, button, a} = React.DOM

class SlackPage.ButtonContainer extends React.Component
  constructor: (props) ->
    super props

    @state =
      accepted: @props.accepted

  sendInviteRequest: =>
    return unless @props.isEligible

    LoadingOverlay.show()

    $.ajax laroute.route('slack.agree'),
      method: 'POST',
      dataType: 'JSON'

    .done () =>
      @setState accepted: true

    .fail (xhr) =>
      osu.ajaxError xhr

    .always LoadingOverlay.hide

  render: ->
    issuesClasses = 'slack-button-container__issues'
    buttonClasses = 'btn-osu slack-button-container__button'

    if @props.isEligible
      issuesClasses += ' slack-button-container__issues--hidden'
      buttonClasses += ' btn-osu-default'
    else
      buttonClasses += ' disabled'

    div className: 'slack-button-container',
      if _.isEmpty currentUser
        p className: 'slack-button-container__notice',
          osu.trans 'community.slack.guest-begin'
          a
            className: 'js-user-link'
            href: '#'
            title: osu.trans 'users.anonymous.login_link'
            osu.trans 'community.slack.guest-middle'
          osu.trans 'community.slack.guest-end'

      else if @state.accepted
        if @props.isInviteAccepted
          p
            className: 'slack-button-container__notice',
            dangerouslySetInnerHTML: { __html: osu.trans('community.slack.invite-already-accepted', mail: @props.supportMail) }

        else
          p className: 'slack-button-container__notice slack-button-container__notice--accepted',
            osu.trans 'community.slack.accepted'
      else
        div className: '',
          p
            className: issuesClasses,
            dangerouslySetInnerHTML: { __html: osu.trans('community.slack.recent-issues', mail: @props.supportMail) }
          button className: buttonClasses, onClick: @sendInviteRequest,
            osu.trans 'community.slack.agree-button'
