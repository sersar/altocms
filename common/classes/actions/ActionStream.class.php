<?php
/*---------------------------------------------------------------------------
 * @Project: Alto CMS
 * @Project URI: http://altocms.com
 * @Description: Advanced Community Engine
 * @Copyright: Alto CMS Team
 * @License: GNU GPL v2 & MIT
 *----------------------------------------------------------------------------
 * Based on
 *   LiveStreet Engine Social Networking by Mzhelskiy Maxim
 *   Site: www.livestreet.ru
 *   E-mail: rus.engine@gmail.com
 *----------------------------------------------------------------------------
 */

/**
 * Экшен обработки ленты активности
 *
 * @package actions
 * @since   1.0
 */
class ActionStream extends Action {
    /**
     * Текущий пользователь
     *
     * @var ModuleUser_EntityUser|null
     */
    protected $oUserCurrent;
    /**
     * Какое меню активно
     *
     * @var string
     */
    protected $sMenuItemSelect = 'follow';

    /**
     * Инициализация
     *
     */
    public function Init() {
        /**
         * Личная лента доступна только для авторизованных, для гостей показываем общую ленту
         */
        $this->oUserCurrent = E::ModuleUser()->GetUserCurrent();
        if ($this->oUserCurrent) {
            $this->SetDefaultEvent('follow');
        } else {
            $this->SetDefaultEvent('all');
        }
        E::ModuleViewer()->Assign('aStreamEventTypes', E::ModuleStream()->GetEventTypes());

        E::ModuleViewer()->Assign('sMenuHeadItemSelect', 'stream');
        /**
         * Загружаем в шаблон JS текстовки
         */
        E::ModuleLang()->AddLangJs(
            array(
                 'stream_subscribes_already_subscribed', 'error'
            )
        );
    }

    /**
     * Регистрация евентов
     *
     */
    protected function RegisterEvent() {

        $this->AddEvent('follow', 'EventFollow');
        $this->AddEvent('all', 'EventAll');
        $this->AddEvent('subscribe', 'EventSubscribe');
        $this->AddEvent('subscribeByLogin', 'EventSubscribeByLogin');
        $this->AddEvent('unsubscribe', 'EventUnSubscribe');
        $this->AddEvent('switchEventType', 'EventSwitchEventType');

        $this->AddEvent('get_more', 'EventGetMoreFollow');
        $this->AddEvent('get_more_follow', 'EventGetMoreFollow');
        $this->AddEvent('get_more_user', 'EventGetMoreUser');
        $this->AddEvent('get_more_all', 'EventGetMoreAll');
    }

    /**
     * Список событий в ленте активности пользователя
     *
     */
    protected function EventFollow() {
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            return parent::EventNotFound();
        }
        $this->sMenuItemSelect = 'follow';

        $oSkin = E::ModuleSkin()->GetSkin(E::ModuleViewer()->GetConfigSkin());
        if ($oSkin && $oSkin->GetCompatible() == 'alto') {
            E::ModuleViewer()->AddWidget('right', 'activitySettings');
            E::ModuleViewer()->AddWidget('right', 'activityFriends');
            E::ModuleViewer()->AddWidget('right', 'activityUsers');
        } else {
            E::ModuleViewer()->AddWidget('right', 'streamConfig');
        }

        /**
         * Читаем события
         */
        $aEvents = E::ModuleStream()->Read();
        E::ModuleViewer()->Assign(
            'bDisableGetMoreButton',
            E::ModuleStream()->GetCountByReaderId($this->oUserCurrent->getId()) < Config::Get('module.stream.count_default')
        );
        E::ModuleViewer()->Assign('aStreamEvents', $aEvents);
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            E::ModuleViewer()->Assign('iStreamLastId', $oEvenLast->getId());
        }
    }

    /**
     * Список событий в общей ленте активности сайта
     *
     */
    protected function EventAll() {

        $this->sMenuItemSelect = 'all';
        /**
         * Читаем события
         */
        $aEvents = E::ModuleStream()->ReadAll();
        E::ModuleViewer()->Assign(
            'bDisableGetMoreButton', E::ModuleStream()->GetCountAll() < Config::Get('module.stream.count_default')
        );
        E::ModuleViewer()->Assign('aStreamEvents', $aEvents);
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            E::ModuleViewer()->Assign('iStreamLastId', $oEvenLast->getId());
        }
    }

    /**
     * Активаци/деактивация типа события
     *
     */
    protected function EventSwitchEventType() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        if (!F::GetRequest('type')) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
        }
        /**
         * Активируем/деактивируем тип
         */
        E::ModuleStream()->SwitchUserEventType($this->oUserCurrent->getId(), F::GetRequestStr('type'));
        E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('stream_subscribes_updated'), E::ModuleLang()->Get('attention'));
    }

    /*
     * LS-compatibility
     */
    protected function EventGetMore() {

        return $this->EventGetMoreFollow();
    }

    /**
     * Погрузка событий (замена постраничности)
     *
     */
    protected function EventGetMoreFollow() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        /**
         * Необходимо передать последний просмотренный ID событий
         */
        $iFromId = F::GetRequestStr('iLastId');
        if (!$iFromId) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
            return;
        }
        /**
         * Получаем события
         */
        $aEvents = E::ModuleStream()->Read(null, $iFromId);

        $aVars = array();

        $aVars['aStreamEvents'] = $aEvents;
        $aVars['sDateLast'] = F::GetRequestStr('sDateLast');
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            E::ModuleViewer()->AssignAjax('iStreamLastId', $oEvenLast->getId());
        }
        /**
         * Возвращаем данные в ajax ответе
         */
        E::ModuleViewer()->AssignAjax('result', E::ModuleViewer()->Fetch('actions/stream/action.stream.events.tpl', $aVars));
        E::ModuleViewer()->AssignAjax('events_count', count($aEvents));
    }

    /**
     * Погрузка событий для всего сайта
     *
     */
    protected function EventGetMoreAll() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        /**
         * Необходимо передать последний просмотренный ID событий
         */
        $iFromId = F::GetRequestStr('iLastId');
        if (!$iFromId) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
            return;
        }
        /**
         * Получаем события
         */
        $aEvents = E::ModuleStream()->ReadAll(null, $iFromId);

        $aVars = array(
            'aStreamEvents' => $aEvents,
            'sDateLast'     => F::GetRequestStr('sDateLast'),
        );
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            E::ModuleViewer()->AssignAjax('iStreamLastId', $oEvenLast->getId());
        }
        /**
         * Возвращаем данные в ajax ответе
         */
        E::ModuleViewer()->AssignAjax('result', E::ModuleViewer()->Fetch('actions/stream/action.stream.events.tpl', $aVars));
        E::ModuleViewer()->AssignAjax('events_count', count($aEvents));
    }

    /**
     * Подгрузка событий для пользователя
     *
     */
    protected function EventGetMoreUser() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        /**
         * Необходимо передать последний просмотренный ID событий
         */
        $iFromId = F::GetRequestStr('iLastId');
        if (!$iFromId) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
            return;
        }
        if (!($oUser = E::ModuleUser()->GetUserById(F::GetRequestStr('iUserId')))) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
            return;
        }
        /**
         * Получаем события
         */
        $aEvents = E::ModuleStream()->ReadByUserId($oUser->getId(), null, $iFromId);

        $aVars = array(
            'aStreamEvents' => $aEvents,
            'sDateLast'     => F::GetRequestStr('sDateLast'),
        );
        if (count($aEvents)) {
            $oEvenLast = end($aEvents);
            E::ModuleViewer()->AssignAjax('iStreamLastId', $oEvenLast->getId());
        }
        /**
         * Возвращаем данные в ajax ответе
         */
        E::ModuleViewer()->AssignAjax('result', E::ModuleViewer()->Fetch('actions/stream/action.stream.events.tpl', $aVars));
        E::ModuleViewer()->AssignAjax('events_count', count($aEvents));
    }

    /**
     * Подписка на пользователя по ID
     *
     */
    protected function EventSubscribe() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        /**
         * Проверяем существование пользователя
         */
        if (!E::ModuleUser()->GetUserById(F::GetRequestStr('id'))) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
        }
        if ($this->oUserCurrent->getId() == F::GetRequestStr('id')) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('stream_error_subscribe_to_yourself'), E::ModuleLang()->Get('error'));
            return;
        }
        /**
         * Подписываем на пользователя
         */
        E::ModuleStream()->SubscribeUser($this->oUserCurrent->getId(), F::GetRequestStr('id'));
        E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('stream_subscribes_updated'), E::ModuleLang()->Get('attention'));
    }

    /**
     * Подписка на пользователя по логину
     *
     */
    protected function EventSubscribeByLogin() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        $sUserLogin = $this->GetPost('login');
        if (!$sUserLogin) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
            return;
        }
        /**
         * Проверяем существование пользователя
         */
        $oUser = E::ModuleUser()->GetUserByLogin($sUserLogin);
        if (!$oUser) {
            E::ModuleMessage()->AddError(
                E::ModuleLang()->Get('user_not_found', array('login' => htmlspecialchars(F::GetRequestStr('login')))),
                E::ModuleLang()->Get('error')
            );
            return;
        }
        if ($this->oUserCurrent->getId() == $oUser->getId()) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('stream_error_subscribe_to_yourself'), E::ModuleLang()->Get('error'));
            return;
        }
        /**
         * Подписываем на пользователя
         */
        E::ModuleStream()->SubscribeUser($this->oUserCurrent->getId(), $oUser->getId());
        E::ModuleViewer()->AssignAjax('uid', $oUser->getId());
        E::ModuleViewer()->AssignAjax('user_login', $oUser->getLogin());
        E::ModuleViewer()->AssignAjax('user_web_path', $oUser->getUserWebPath());
        E::ModuleViewer()->AssignAjax('user_avatar_48', $oUser->getAvatarUrl(48));
        E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('userfeed_subscribes_updated'), E::ModuleLang()->Get('attention'));
    }

    /**
     * Отписка от пользователя
     *
     */
    protected function EventUnsubscribe() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        E::ModuleViewer()->SetResponseAjax('json');
        /**
         * Пользователь авторизован?
         */
        if (!$this->oUserCurrent) {
            parent::EventNotFound();
        }
        /**
         * Пользователь с таким ID существует?
         */
        if (!E::ModuleUser()->GetUserById(F::GetRequestStr('id'))) {
            E::ModuleMessage()->AddError(E::ModuleLang()->Get('system_error'), E::ModuleLang()->Get('error'));
        }
        /**
         * Отписываем
         */
        E::ModuleStream()->UnsubscribeUser($this->oUserCurrent->getId(), F::GetRequestStr('id'));
        E::ModuleMessage()->AddNotice(E::ModuleLang()->Get('stream_subscribes_updated'), E::ModuleLang()->Get('attention'));
    }

    /**
     * Выполняется при завершении работы экшена
     *
     */
    public function EventShutdown() {
        /**
         * Загружаем в шаблон необходимые переменные
         */
        E::ModuleViewer()->Assign('sMenuItemSelect', $this->sMenuItemSelect);
    }

}

// EOF