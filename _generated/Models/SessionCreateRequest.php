<?php

namespace GhostCrawl\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class SessionCreateRequest implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var SessionCreateRequest_device|null $device Device class for the population identity draw. 'random' (default) = the unchanged population draw for the requested engine. 'random_desktop' (windows/macos/linux), 'random_mobile' (ios/android), 'random_windows', 'random_android', 'random_ios' restrict WHICH real-population devices may be drawn; the weights inside the class stay the real OS/browser/device shares. When engine is omitted (or 'auto') the engine is routed from the drawn device: iOS -> webkit (always), android -> chrome, desktop -> chrome/firefox/webkit per the real browser share. An explicit engine the class cannot render on (e.g. random_ios + chrome) is rejected with 422 device_engine_mismatch, never re-routed. NOTE: an explicitly sent engine='chrome' counts as explicit even though it equals the default, so a client that always serializes engine must send 'auto' (or omit it) with random_ios / random_mobile. With identity_config/profile the operating system must lie inside the class (422 device_identity_mismatch). 'static' pins ONE fixed device: pass device_seed (the same seed always yields the same device and a byte-stable fingerprint), or a profile, or an identity_config carrying reuse_identity_seed (422 device_static_requires_seed otherwise).
    */
    private ?SessionCreateRequest_device $device = null;
    
    /**
     * @var SessionCreateRequest_device_seed|null $device_seed device='static' only: a stable non-negative integer, scoped to YOUR organization (the server derives the identity from org + seed, so another org's seed 1 is a different device). Seeds the population device draw AND pins the fingerprint, so every create from this org with the same seed (and engine) is the same device. Store it to bring the same device back.
    */
    private ?SessionCreateRequest_device_seed $device_seed = null;
    
    /**
     * @var SessionCreateRequest_engine|null $engine The engine property
    */
    private ?SessionCreateRequest_engine $engine = null;
    
    /**
     * @var SessionCreateRequest_identity_country|null $identity_country Geo-pin for the residential exit (ISO country, e.g. 'US'). The session's timezone/geolocation follow the drawn exit's country (geo-coherence).
    */
    private ?SessionCreateRequest_identity_country $identity_country = null;
    
    /**
     * @var SessionCreateRequest_profile|null $profile Named persistent profile. Rehydrates the saved identity bundle for this session, the same browser identity as /v1/scrape with profile=<name>.
    */
    private ?SessionCreateRequest_profile $profile = null;
    
    /**
     * Instantiates a new SessionCreateRequest and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setDevice(new SessionCreateRequest_device('random'));
        $this->setEngine(new SessionCreateRequest_engine('chrome'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return SessionCreateRequest
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): SessionCreateRequest {
        return new SessionCreateRequest();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the device property value. Device class for the population identity draw. 'random' (default) = the unchanged population draw for the requested engine. 'random_desktop' (windows/macos/linux), 'random_mobile' (ios/android), 'random_windows', 'random_android', 'random_ios' restrict WHICH real-population devices may be drawn; the weights inside the class stay the real OS/browser/device shares. When engine is omitted (or 'auto') the engine is routed from the drawn device: iOS -> webkit (always), android -> chrome, desktop -> chrome/firefox/webkit per the real browser share. An explicit engine the class cannot render on (e.g. random_ios + chrome) is rejected with 422 device_engine_mismatch, never re-routed. NOTE: an explicitly sent engine='chrome' counts as explicit even though it equals the default, so a client that always serializes engine must send 'auto' (or omit it) with random_ios / random_mobile. With identity_config/profile the operating system must lie inside the class (422 device_identity_mismatch). 'static' pins ONE fixed device: pass device_seed (the same seed always yields the same device and a byte-stable fingerprint), or a profile, or an identity_config carrying reuse_identity_seed (422 device_static_requires_seed otherwise).
     * @return SessionCreateRequest_device|null
    */
    public function getDevice(): ?SessionCreateRequest_device {
        return $this->device;
    }

    /**
     * Gets the device_seed property value. device='static' only: a stable non-negative integer, scoped to YOUR organization (the server derives the identity from org + seed, so another org's seed 1 is a different device). Seeds the population device draw AND pins the fingerprint, so every create from this org with the same seed (and engine) is the same device. Store it to bring the same device back.
     * @return SessionCreateRequest_device_seed|null
    */
    public function getDeviceSeed(): ?SessionCreateRequest_device_seed {
        return $this->device_seed;
    }

    /**
     * Gets the engine property value. The engine property
     * @return SessionCreateRequest_engine|null
    */
    public function getEngine(): ?SessionCreateRequest_engine {
        return $this->engine;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'device' => fn(ParseNode $n) => $o->setDevice($n->getEnumValue(SessionCreateRequest_device::class)),
            'device_seed' => fn(ParseNode $n) => $o->setDeviceSeed($n->getObjectValue([SessionCreateRequest_device_seed::class, 'createFromDiscriminatorValue'])),
            'engine' => fn(ParseNode $n) => $o->setEngine($n->getEnumValue(SessionCreateRequest_engine::class)),
            'identity_country' => fn(ParseNode $n) => $o->setIdentityCountry($n->getObjectValue([SessionCreateRequest_identity_country::class, 'createFromDiscriminatorValue'])),
            'profile' => fn(ParseNode $n) => $o->setProfile($n->getObjectValue([SessionCreateRequest_profile::class, 'createFromDiscriminatorValue'])),
        ];
    }

    /**
     * Gets the identity_country property value. Geo-pin for the residential exit (ISO country, e.g. 'US'). The session's timezone/geolocation follow the drawn exit's country (geo-coherence).
     * @return SessionCreateRequest_identity_country|null
    */
    public function getIdentityCountry(): ?SessionCreateRequest_identity_country {
        return $this->identity_country;
    }

    /**
     * Gets the profile property value. Named persistent profile. Rehydrates the saved identity bundle for this session, the same browser identity as /v1/scrape with profile=<name>.
     * @return SessionCreateRequest_profile|null
    */
    public function getProfile(): ?SessionCreateRequest_profile {
        return $this->profile;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeEnumValue('device', $this->getDevice());
        $writer->writeObjectValue('device_seed', $this->getDeviceSeed());
        $writer->writeEnumValue('engine', $this->getEngine());
        $writer->writeObjectValue('identity_country', $this->getIdentityCountry());
        $writer->writeObjectValue('profile', $this->getProfile());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the device property value. Device class for the population identity draw. 'random' (default) = the unchanged population draw for the requested engine. 'random_desktop' (windows/macos/linux), 'random_mobile' (ios/android), 'random_windows', 'random_android', 'random_ios' restrict WHICH real-population devices may be drawn; the weights inside the class stay the real OS/browser/device shares. When engine is omitted (or 'auto') the engine is routed from the drawn device: iOS -> webkit (always), android -> chrome, desktop -> chrome/firefox/webkit per the real browser share. An explicit engine the class cannot render on (e.g. random_ios + chrome) is rejected with 422 device_engine_mismatch, never re-routed. NOTE: an explicitly sent engine='chrome' counts as explicit even though it equals the default, so a client that always serializes engine must send 'auto' (or omit it) with random_ios / random_mobile. With identity_config/profile the operating system must lie inside the class (422 device_identity_mismatch). 'static' pins ONE fixed device: pass device_seed (the same seed always yields the same device and a byte-stable fingerprint), or a profile, or an identity_config carrying reuse_identity_seed (422 device_static_requires_seed otherwise).
     * @param SessionCreateRequest_device|null $value Value to set for the device property.
    */
    public function setDevice(?SessionCreateRequest_device $value): void {
        $this->device = $value;
    }

    /**
     * Sets the device_seed property value. device='static' only: a stable non-negative integer, scoped to YOUR organization (the server derives the identity from org + seed, so another org's seed 1 is a different device). Seeds the population device draw AND pins the fingerprint, so every create from this org with the same seed (and engine) is the same device. Store it to bring the same device back.
     * @param SessionCreateRequest_device_seed|null $value Value to set for the device_seed property.
    */
    public function setDeviceSeed(?SessionCreateRequest_device_seed $value): void {
        $this->device_seed = $value;
    }

    /**
     * Sets the engine property value. The engine property
     * @param SessionCreateRequest_engine|null $value Value to set for the engine property.
    */
    public function setEngine(?SessionCreateRequest_engine $value): void {
        $this->engine = $value;
    }

    /**
     * Sets the identity_country property value. Geo-pin for the residential exit (ISO country, e.g. 'US'). The session's timezone/geolocation follow the drawn exit's country (geo-coherence).
     * @param SessionCreateRequest_identity_country|null $value Value to set for the identity_country property.
    */
    public function setIdentityCountry(?SessionCreateRequest_identity_country $value): void {
        $this->identity_country = $value;
    }

    /**
     * Sets the profile property value. Named persistent profile. Rehydrates the saved identity bundle for this session, the same browser identity as /v1/scrape with profile=<name>.
     * @param SessionCreateRequest_profile|null $value Value to set for the profile property.
    */
    public function setProfile(?SessionCreateRequest_profile $value): void {
        $this->profile = $value;
    }

}
