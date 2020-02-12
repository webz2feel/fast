<?php

namespace Fast\Vendor\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Vendor\Http\Resources\VendorResource;
use Fast\Vendor\Repositories\Interfaces\VendorInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RvMedia;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * @var VendorInterface
     */
    protected $vendorRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param VendorInterface $vendorRepository
     */
    public function __construct(VendorInterface $vendorRepository)
    {
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * Get the user profile information.
     *
     * @group Profile
     * @authenticated
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function getProfile(Request $request, BaseHttpResponse $response)
    {
        $user = $request->user();

        return $response->setData(new VendorResource($user));
    }

    /**
     * Update Avatar
     *
     * @bodyParam avatar file required Avatar file.
     *
     * @group Profile
     * @authenticated
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function updateAvatar(Request $request, BaseHttpResponse $response)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpg,jpeg,png',
        ]);

        if ($validator->fails()) {
            return $response
                ->setError()
                ->setCode(422)
                ->setMessage(__('Data invalid!') . ' ' . implode(' ', $validator->errors()->all()) . '.');
        }

        try {

            $file = RvMedia::handleUpload($request->file('avatar'), 0, 'vendors');
            if (Arr::get($file, 'error') !== true) {
                $user = $this->vendorRepository->createOrUpdate(['avatar' => $file['data']->url],
                    ['id' => $request->user()->getKey()]);
            }

            return $response
                ->setData([
                    'avatar' => $user->avatar_url,
                ])
                ->setMessage(__('Update avatar successfully!'));

        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * Update profile
     *
     * @bodyParam first_name string required First name.
     * @bodyParam last_name string required Last name.
     * @bodyParam email string Email.
     * @bodyParam dob string required Date of birth.
     * @bodyParam gender string Gender
     * @bodyParam description string Description
     * @bodyParam phone string required Phone.
     *
     * @group Profile
     * @authenticated
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function updateProfile(Request $request, BaseHttpResponse $response)
    {
        $userId = $request->user()->getKey();

        $validator = Validator::make($request->input(), [
            'first_name'  => 'required|max:120|min:2',
            'last_name'   => 'required|max:120|min:2',
            'phone'       => 'required|max:15|min:8',
            'dob'         => 'required|max:15|min:8',
            'gender'      => 'nullable',
            'description' => 'nullable',
            'email'       => 'nullable|max:60|min:6|email|unique:vendors,email,' . $userId,
        ]);

        if ($validator->fails()) {
            return $response
                ->setError()
                ->setCode(422)
                ->setMessage(__('Data invalid!') . ' ' . implode(' ', $validator->errors()->all()) . '.');
        }

        try {
            $user = $this->vendorRepository->createOrUpdate($request->input(), ['id' => $userId]);

            return $response
                ->setData($user->toArray())
                ->setMessage(__('Update profile successfully!'));

        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * Update password
     *
     * @bodyParam password string required The new password of vendor.
     *
     * @group Profile
     * @authenticated
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function updatePassword(Request $request, BaseHttpResponse $response)
    {
        $validator = Validator::make($request->input(), [
            'password' => 'required|min:6|max:60',
        ]);

        if ($validator->fails()) {
            return $response
                ->setError()
                ->setCode(422)
                ->setMessage(__('Data invalid!') . ' ' . implode(' ', $validator->errors()->all()) . '.');
        }

        $currentUser = $request->user();

        $this->vendorRepository->update(['id' => $currentUser->getKey()], [
            'password' => bcrypt($request->input('password')),
        ]);

        return $response->setMessage(trans('core/acl::users.password_update_success'));
    }
}
