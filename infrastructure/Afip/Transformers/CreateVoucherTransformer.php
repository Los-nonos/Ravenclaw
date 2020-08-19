<?php


namespace Infrastructure\Afip\Transformers;


use Application\Exceptions\CurrencyNotSupport;
use Application\Services\Afip\CreateVoucherCommand;
use DateTimeImmutable;
use Infrastructure\Afip\Exceptions\InvalidAfipConcept;
use Infrastructure\Afip\Exceptions\InvalidAfipTypeVoucher;
use Infrastructure\Afip\Exceptions\InvalidDateService;
use Infrastructure\Afip\Exceptions\InvalidTypeDocument;
use Money\Money;

class CreateVoucherTransformer
{
    public function transform(CreateVoucherCommand $command) {
        return [
            'CantReg' 		=> $command->getVoucherQuantity(), // Cantidad de comprobantes a registrar
            'PtoVta' 		=> $command->getPointOfSale(), // Punto de venta
            'CbteTipo' 		=> $this->parseTypeVoucher($command->getTypeVoucher()), // Tipo de comprobante (ver tipos disponibles)
            'Concepto' 		=> $this->parseConcept($command->getConcept()), // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
            'DocTipo' 		=> $this->parseTypeDocument($command->getBuyerTypeDocument()), // Tipo de documento del comprador (ver tipos disponibles)
            'DocNro' 		=> $command->getBuyerDocumentNumber(), // Numero de documento del comprador
            'CbteDesde' 	=> 1, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
            'CbteHasta' 	=> 1, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
            'CbteFch' 		=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
            'ImpTotal' 		=> ($command->getTotalMoney()->getAmount() / 100), // Importe total del comprobante
            'ImpTotConc' 	=> ($command->getAmountNotTaxed()->getAmount() / 100), // Importe neto no gravado
            'ImpNeto' 		=> ($command->getTaxNet()->getAmount() / 100), // Importe neto gravado
            'ImpOpEx' 		=> $command->getTaxExempt() ? ($command->getTaxExempt()->getAmount() / 100) : 0, // Importe exento de IVA
            'ImpIVA' 		=> ($command->getTotalIva()->getAmount() / 100), //Importe total de IVA
            'ImpTrib' 		=> ($command->getTotalTributes()->getAmount() / 100), //Importe total de tributos
            'FchServDesde' 	=> $this->parseServicesDate($command->getTypeVoucher(), $command->getInitDate()), // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
            'FchServHasta' 	=> $this->parseServicesDate($command->getTypeVoucher(), $command->getEndDate()), // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
            'FchVtoPago' 	=> $this->parseServicesDate($command->getTypeVoucher(), $command->getExpirationDate()), // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
            'MonId' 		=> $this->parseCurrency($command->getTotalMoney()), //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos)
            'MonCotiz' 		=> 1, // Cotización de la moneda usada (1 para pesos argentinos)
//            'CbtesAsoc' 	=> array( // (Opcional) Comprobantes asociados
//                array(
//                    'Tipo' 		=> 6, // Tipo de comprobante (ver tipos disponibles)
//                    'PtoVta' 	=> 1, // Punto de venta
//                    'Nro' 		=> 1, // Numero de comprobante
//                    'Cuit' 		=> 20111111112 // (Opcional) Cuit del emisor del comprobante
//                )
//            ),
//            'Tributos' 		=> array( // (Opcional) Tributos asociados al comprobante
//                array(
//                    'Id' 		=>  99, // Id del tipo de tributo (ver tipos disponibles)
//                    'Desc' 		=> 'Ingresos Brutos', // (Opcional) Descripcion
//                    'BaseImp' 	=> 150, // Base imponible para el tributo
//                    'Alic' 		=> 5.2, // Alícuota
//                    'Importe' 	=> 7.8 // Importe del tributo
//                )
//            ),
//            'Iva' 			=> array( // (Opcional) Alícuotas asociadas al comprobante
//                array(
//                    'Id' 		=> 5, // Id del tipo de IVA (ver tipos disponibles)
//                    'BaseImp' 	=> 100, // Base imponible
//                    'Importe' 	=> 21 // Importe
//                )
//            ),
//            'Opcionales' 	=> array( // (Opcional) Campos auxiliares
//                array(
//                    'Id' 		=> 17, // Codigo de tipo de opcion (ver tipos disponibles)
//                    'Valor' 	=> 2 // Valor
//                )
//            ),
//            'Compradores' 	=> array( // (Opcional) Detalles de los clientes del comprobante
//                array(
//                    'DocTipo' 		=> 80, // Tipo de documento (ver tipos disponibles)
//                    'DocNro' 		=> 20111111112, // Numero de documento
//                    'Porcentaje' 	=> 100 // Porcentaje de titularidad del comprador
//                )
//            )
        ];
    }

    private function parseTypeDocument($getTypeDocument)
    {
        switch ($getTypeDocument) {
            case '':
                return '';
            default:
                throw new InvalidTypeDocument();
        }
    }

    private function parseTypeVoucher($getTypeVoucher)
    {
        switch ($getTypeVoucher) {
            case '':
                return '';
            default:
                throw new InvalidAfipTypeVoucher();
        }
    }

    private function parseCurrency(Money $getTotalMoney)
    {
        if ($getTotalMoney->getCurrency()->getName() === 'ARS') {
            return 'PES';
        } else {
            throw new CurrencyNotSupport();
        }
    }

    private function parseConcept($getConcept)
    {
        switch ($getConcept) {
            case 'Products':
                return 1;
            case 'Services':
                return 2;
            case 'Products and Services':
                return 3;
            default:
                throw new InvalidAfipConcept();
        }
    }

    private function parseServicesDate(string $typeVoucher, DateTimeImmutable $getInitDate)
    {
        $concept = $this->parseConcept($typeVoucher);

        if ($concept > 1) {
            if (isset($getInitDate)) {
                throw new InvalidDateService();
            }
            return $getInitDate->format('Ymd');
        }else {
            return null;
        }
    }
}
