<?php


namespace App\Http\RoutesInfo\V1;


class PasswordInfo
{
    public const Id = 'id';
    public const UserId = 'user_id';
    public const Website = 'website';
    public const Username = 'username';
    public const Value = 'value';
    public const Name = 'name';
    public const Note = 'note';

    public const Base = 'passwords';
    public const Self = self::Base.'-self';
    public const Index = self::Base.'-index';
    public const Show = self::Base.'-show';
    public const Update = self::Base.'-update';
    public const Store = self::Base.'-store';
    public const Destroy = self::Base.'-destroy';

}
