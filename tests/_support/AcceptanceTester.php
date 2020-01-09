<?php


/**
 * Inherited Methods.
 *
 * @method void                    wantToTest($text)
 * @method void                    wantTo($text)
 * @method void                    execute($callable)
 * @method void                    expectTo($prediction)
 * @method void                    expect($prediction)
 * @method void                    amGoingTo($argumentation)
 * @method void                    am($role)
 * @method void                    lookForwardTo($achieveValue)
 * @method void                    comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Войти в систему. Вызывать в _before.
     *
     * @param string $user
     * @param string $pass
     */
    public function login($user = 'codeception', $pass = 'topsecurity')
    {
        $this->amOnPage('/');
        $this->seeElement('#login');
        $this->seeElement('#password');
        $this->fillField('#login', $user);
        $this->fillField('#password', $pass);
        $this->click('#submit');

        $this->seeResponseCodeIs(200);
        $this->seeElement('.navbar-user-name');
    }

    /**
     * Выйти из системы.
     */
    public function logout()
    {
        $this->amOnPage('/auth/logout/');
        $this->seeElement('#login');
    }

    /**
     * Обертка над click, позволяющая нажать кнопку, текст которой соответсвует паттерну
     * В случае, если в ссылке содержится не только искомое слово, но и некий другой текст.
     *
     * Метод собирает текст из элементов, указанных по селектору $context
     * И в собранных текстах проверяет соответ. паттерну, в случае совпадение
     * происходит нажатие.
     *
     * @param string $substring
     * @param null   $context
     */
    public function clickLinkLike($substring, $context = null)
    {
        $linksTextList = $this->grabMultiple($context);
        foreach ($linksTextList as $linkTest) {
            if (preg_match('/.*(' . $substring . ').*/u', $linkTest, $matches)) {
                $this->click($linkTest, $context);
            }
        }
    }

    /**
     * Обертка для проверки успеха и отсутствия сообщения об ошибках на странице.
     */
    public function dontSeePHPErrors()
    {
        $this->seeResponseCodeIs(200);
        $this->dontSee('Notice');
        $this->dontSee('Warning');
        $this->dontSee('Fatal error');
        $this->dontSee('Стек вызовов');
    }
}
