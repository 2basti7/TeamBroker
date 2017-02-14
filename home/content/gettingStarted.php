<!-- Custom CSS -->
<!-- Custom Fonts -->
<style>
    .panel_font_size_big {
        font-size: 1.4em;
    }

    .panel_font_size_small {
        font-size: 1.1em;
    }
</style>
<!-- container -->
<div class="col-md-12">
    <!-- info of how to use functions -->
    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading panel_font_size_big">
                General informations
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion1">
                        <div class="panel panel-default">
                            <!-- contents  -->
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion1"
                                       href="#collapsea">
                                        Content of this site</a>
                                </h4>
                            </div>
                            <!-- collapsea is hidden on larger screens, but visible when the menu is Fading -->
                            <div id="collapsea" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    This website gives the user the option to find correlations between selected stocks.
                                    The user can choose from a variety of ticker-symbols from different stock exchanges
                                    (e.g. Nasdaq, NYSE)
                                    and get more information about them. The technique, that is used to find
                                    correlation, is cross-correlation.
                                    Cross-correlation is a method, which calculates the correlation-coefficient between
                                    two different signals with different
                                    time delays.

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion1"
                                       href="#collapseb">
                                        How to use this site</a>
                                </h3>
                            </div>
                            <!-- collapseb is hidden on larger screens, but visible when the menu is Fading -->
                            <div id="collapseb" class="panel-collapse collapse">
                                <div class="panel-body">Beside daily and general informations to selected stocks and
                                    companies, the user can choose from different calculation methods.
                                    For example, he can investigate the correlation of two stocks in a choosen
                                    timeframe. Additionaly he can compare a stock with over 5000
                                    other stocks and find the best correlating stocks out of these.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion1"
                                       href="#collapsec">
                                        Underlying principles</a>
                                </h3>
                            </div>
                            <!-- collapsec is hidden on larger screens, but visible when the menu is Fading -->
                            <div id="collapsec" class="panel-collapse collapse">
                                <div class="panel-body">To determine the correlation between two stocks, the method of
                                    cross-correlation is used. It describes the correlation between two signals x and y
                                    with different time delays. That means signal x is not moved, while signal y gets
                                    shifted by a given value (delay). Then the correlation between theses
                                    is calculated. The correlation-coefficient can have a value between -1 and 1. Values
                                    that are close to -1 describe a high negative relation, while values
                                    that are close to 1 describe a high positive relation. To describe the
                                    correlation-coefficient, the following classification is used:
                                    <ul>
                                        <!-- info for measuring stocks -->
                                        <li>>= 0.7 : strong significant</li>
                                        <li>>= 0.5 & <= 0.7 : moderate significant</li>
                                        <li>>= 0.3 & < 0.5 : weak</li>
                                        <li>>= 0.1 & < 0.3 : very weak</li>
                                        <li>< 0.1 : insignificant</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Controls -->
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel_font_size_big">
                Supported tools and calculations
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="panel-group" id="accordion2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion2"
                                       href="#collapse_2_1">
                                        I. Input variables</a>
                                </h4>
                            </div>
                            <!-- collapse_2_1 is hidden on larger screens, but visible when the menu is Fading -->
                            <div id="collapse_2_1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item"><strong>Ticker (symbol):</strong> Ticker symbol from
                                            the database
                                        </li>
                                        <li class="list-group-item"><strong>Date:</strong> Start or end date for which
                                            we want to get the course changes for calculations
                                        </li>
                                        <li class="list-group-item"><strong>Timeframe:</strong> Length of days which are
                                            used for calculating correlation
                                        </li>
                                        <!-- <li class="list-group-item"><strong>Shiftfenster:</strong> Anzahl der Werte die Verschoben werden: Dieser Wert stellt eine Untermenge der
                                             Werte des globalen Zeitfensters dar. Da bei 100 Werten der Korrelationswert zu sehr
                                             verzerrt werden würde, wird hier eine Auswahl getroffen. Dann wird aus dem globalen
                                             Zeitfenster die Anzahl der Tage des Ereigniszeitraums geschnitten. Mit diesen Werten
                                             wird dann die Kreuzkorrelation berechnet. Anschließnd wird der das
                                             Betrachtungsfenster einen Tag weitergeschoben.-->
                                        </li>
                                        <li class="list-group-item"><strong>Lag:</strong> Maximum delay which is used to
                                            calculate correlation
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion2"
                                       href="#collapse_2_2">
                                        II. Compare two tickers</a>
                                </h3>
                            </div>
                            <!-- collapse_2_2 is hidden on larger screens, but visible when the menu is Fading -->
                            <div id="collapse_2_2" class="panel-collapse collapse">
                                <div class="panel-body">Der Nutzer wät zwei Ticker aus, ein globales Zeitfenster
                                    (=Anzahl aller Werte), ein Zeitfenster das verschoben werden soll und die maximale
                                    Verschiebung.
                                    Ein Beispiel: Der Nutzer wät Apple und Facebook als Ticker, den 31.1.2017 als
                                    Datum, 100 als globales Zeitfenster, 15 als Verschiebungsfenster und 5 als maximalen
                                    Lag.
                                    Ticker 1 Apple wird immer festgehalten und Ticker 2 Facebook wird verschoben um den
                                    jeweiligen aktuellen Lag. Von den 100 Werten werden lediglich die ersten 15 Werte
                                    betrachtet. Für diese 15 Werte wird dann der Kreuzkorrelationskoeffizient für die
                                    Lags 1 - 5 berechnet. Danach werden die 15 Werte um einen Tag weitergeschoben und es
                                    werden die Werte 2 - 16 betrachtet. Mit diesen 15 Werten wird dann wieder der
                                    Kreuzkorrelationskoeffizient betrachtet.
                                    Nachdem der Kreuzkorrelationskoeffizient für die Werte 80 - 95 mit den Lags von 1-5
                                    berechnet wurde, ist die komplette Berechnung beendet.
                                    Das Ergebnis ist eine Tabelle, die alle Kreuzkorrelationskoeffizienten enthält. Nun
                                    können die Werte betrachtet werden. Ein mögliches Ergebnis könnte laufen. Apple und
                                    Facebook korrelieren im Zeitfenster vom 11.12.2016 - 25.12.2016 bei einem Lag von 3
                                    mit einem Wert von 0.71239684. Folglich ist dieses Ergebnis "Stark signifikant".
                                    Für einen Anleger würde dies bedeuten, dass er bspw. Am 11.12.2016 die Apple Aktie
                                    betrachten sollte und ausgehend von dessen Veräerung dasselbe Verhalten von
                                    Facebook drei Tage spär, also am 14.12.2016 mit einer Wahrscheinlichkeit von 0.71
                                    erwarten könnte.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a class="panel_font_size_small" data-toggle="collapse" data-parent="#accordion2"
                                       href="#collapse_2_3">
                                        III. Compare one ticker against all</a>
                                </h3>
                            </div>
                            <!-- collapse_2_3 is hidden on larger screens, but visible when the menu is Fading -->
                            <div id="collapse_2_3" class="panel-collapse collapse">
                                <div class="panel-body">Hier wird anstatt der Auswahl zweier Ticker, lediglich ein
                                    Ticker ausgewät. Dieser Ticker ist der feste Ticker. Dann wird für die angegebenen
                                    Input Variablen für alle anderen 6000 Ticker aus der DB dieselbe Berechnung wie bei
                                    II gemacht. Das Ergebnis sind dann 6000 interne Tabellen wie in II. Dabei wird dann
                                    in der Tabelle über die jeweiligen Lags der Mittelwert gebildet. Der Output für
                                    diese Berechnung sind die 10 besten und schlechtesten Mittelwerte der
                                    Kreuzkorrelationskoeffizienten für die gegebenen Lags.
                                    Interpretation: Apple als fester Ticker korreliert mit Genetic Company bei einem Lag
                                    von 2 über das komplette betrachtete Zeitfenster im Mittel am besten. Ausgehend von
                                    diesem Ergebnis könnte die Berechnung aus II mit Apple und Genetic folgen, um noch
                                    genauere Informationen zum Korrelationsverhalten zu bekommen.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /col-lg-12 -->
</div>
<!-- /container -->