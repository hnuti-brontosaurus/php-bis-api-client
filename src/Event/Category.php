<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

enum Category: string
{
	case EVP = 'evp'; // výukový program (EVP)
	case EXPERIENTAL = 'experiential'; // zážitková akce
	case INTERNAL = 'internal'; // interní akce
	case INTERNAL_EDUCATIONAL = 'internal_educational'; // vzdělávací pro organizátory HB
	case INTERNAL_EDUCATIONAL_FULL = 'internal_educational_full'; // OHB, Cestičky
	case PRESENTATION = 'presentation'; // prezentační akce
	case PUBLIC_EDUCATIONAL = 'public_educational'; // vzdělávací pro veřejnost
	case SECTION_EVENT = 'section_event'; // oddílová akce
	case SECTION_MEETING = 'section_meeting'; // oddílová schůzka
	case VOLUNTEERING = 'volunteering'; // dobrovolnická akce

	public static function bcCompatibleFrom(string $value): self
	{
		  return match($value) {
			'public__volunteering' => self::VOLUNTEERING,
			'public__only_experiential' => self::EXPERIENTAL,
			'public__educational__lecture' => self::PUBLIC_EDUCATIONAL,
			'public__educational__course' => self::PUBLIC_EDUCATIONAL,
			'public__educational__ohb' => self::INTERNAL_EDUCATIONAL,
			'public__educational__educational' => self::PUBLIC_EDUCATIONAL,
			'public__educational__educational_with_stay' => self::PUBLIC_EDUCATIONAL,
			'public__club__meeting' => self::PUBLIC_EDUCATIONAL,
			'public__club__lecture' => self::PUBLIC_EDUCATIONAL,
			'public__other__for_public' => self::PUBLIC_EDUCATIONAL,
			'public__other__exhibition' => self::PRESENTATION,
			'public__other__eco_tent' => self::PRESENTATION,
			'internal__volunteer_meeting' => self::INTERNAL,
			'internal__general_meeting' => self::INTERNAL,
			'internal__section_meeting' => self::SECTION_MEETING,
			default => self::from($value),
        };
	}
}
