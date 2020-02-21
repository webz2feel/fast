<?php

namespace Fast\Member\Http\Controllers;

use Auth;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Member\Http\Requests\EditAccountRequest;
use Fast\Member\Http\Requests\UpdatePasswordRequest;
use Fast\Member\Http\Requests\MemberChangeAvatarRequest;
use Fast\Member\Repositories\Interfaces\MemberInterface;
use Hash;
use Illuminate\Routing\Controller;
use SeoHelper;
use Theme;

class PublicController extends Controller
{
    /**
     * @var MemberInterface
     */
    protected $memberRepository;

    /**
     * PublicController constructor.
     * @param MemberInterface $memberRepository
     */
    public function __construct(MemberInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;

        Theme::asset()->add('member-css', 'vendor/core/plugins/member/css/member.css');
    }

    /**
     * @return \Response
     * @author Imran Ali
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getOverview()
    {
        SeoHelper::setTitle(Auth::guard('member')->user()->name);
        return Theme::scope('member.overview', [], 'plugins.member::themes.overview')->render();
    }

    /**
     * @return \Response
     * @author Imran Ali
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getEditAccount()
    {
        SeoHelper::setTitle(__('Edit Account'));
        return Theme::scope('member.edit-account', [], 'plugins.member::themes.edit-account')->render();
    }

    /**
     * @param EditAccountRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Imran Ali
     */
    public function postEditAccount(EditAccountRequest $request, BaseHttpResponse $response)
    {
        $this->memberRepository->createOrUpdate($request->input(), ['id' => Auth::guard('member')->user()->getKey()]);
        return $response
            ->setNextUrl(route('public.member.edit'))
            ->setMessage(__('Update profile successfully!'));
    }

    /**
     * @return \Response
     * @author Imran Ali
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getChangePassword()
    {
        SeoHelper::setTitle(__('Change Password'));
        return Theme::scope('member.change-password', [], 'plugins.member::themes.change-password')->render();
    }

    /**
     * @param UpdatePasswordRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author Imran Ali
     */
    public function postChangePassword(UpdatePasswordRequest $request, BaseHttpResponse $response)
    {
        $currentUser = Auth::guard('member')->user();

        if (!Hash::check($request->input('old_password'), $currentUser->getAuthPassword())) {
            return $response
                ->setError()
                ->setMessage(trans('acl::users.current_password_not_valid'));
        }

        $this->memberRepository->update(['id' => $currentUser->getKey()], [
            'password' => bcrypt($request->input('password')),
        ]);

        return $response->setMessage(trans('acl::users.password_update_success'));
    }

    /**
     * @return \Response
     * @author Imran Ali
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getChangeProfileImage()
    {
        SeoHelper::setTitle(__('Change Avatar'));
        return Theme::scope('member.change-profile-image', [], 'plugins.member::themes.change-profile-image')->render();
    }

    /**
     * @author Imran Ali
     * @param MemberChangeAvatarRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function postChangeProfileImage(MemberChangeAvatarRequest $request, BaseHttpResponse $response)
    {
        $file = rv_media_handle_upload($request->file('avatar'), 0, 'members');
        if (array_get($file, 'error') == true) {
            return $response
                ->setError()
                ->setMessage(array_get($file, 'message'));
        }
        $this->memberRepository->createOrUpdate(['avatar' => $file['data']->url], ['id' => Auth::guard('member')->user()->getKey()]);
        return $response->setMessage(__('Update avatar successfully!'));
    }
}
